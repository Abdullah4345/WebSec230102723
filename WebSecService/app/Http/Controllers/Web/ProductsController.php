<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller {

    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

    private function getStockData() {
        $path = storage_path('app/products_stock.json');
        if (!file_exists($path)) {
            file_put_contents($path, json_encode(['products' => []]));
        }
        return json_decode(file_get_contents($path), true);
    }

    private function saveStockData($data) {
        $path = storage_path('app/products_stock.json');
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function getPurchasesData() {
        $path = storage_path('app/purchases.json');
        if (!file_exists($path)) {
            file_put_contents($path, json_encode(['purchases' => []]));
        }
        return json_decode(file_get_contents($path), true);
    }

    private function savePurchasesData($data) {
        $path = storage_path('app/purchases.json');
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function list(Request $request) {

        $query = Product::select("products.*");

        $query->when($request->keywords, 
        fn($q)=> $q->where("name", "like", "%$request->keywords%"));

        $query->when($request->min_price, 
        fn($q)=> $q->where("price", ">=", $request->min_price));
        
        $query->when($request->max_price, fn($q)=> 
        $q->where("price", "<=", $request->max_price));
        
        $query->when($request->order_by, 
        fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

        $products = $query->get();
        $stockData = $this->getStockData();

        foreach ($products as $product) {
            $product->quantity = $stockData['products'][$product->id] ?? 0;
        }

        return view('products.list', compact('products'));
    }

    public function edit(Request $request, Product $product = null) {

        if(!auth()->user()) return redirect('/');

        $product = $product??new Product();

        return view('products.edit', compact('product'));
    }

    public function save(Request $request, Product $product = null) {

        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
        ]);

        $product = $product??new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list');
    }

    public function delete(Request $request, Product $product) {

        if(!auth()->user()->hasPermissionTo('delete_products')) abort(401);

        $product->delete();

        return redirect()->route('products_list');
    }

    public function updateQuantity(Request $request, Product $product) {
        if(!auth()->user()->hasPermissionTo('edit_products')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $this->validate($request, [
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $stockData = $this->getStockData();
        $stockData['products'][$product->id] = $request->quantity;
        $this->saveStockData($stockData);

        return response()->json(['success' => true, 'quantity' => $request->quantity]);
    }

    public function buy(Request $request, Product $product) {
        if(!auth()->check()) {
            return response()->json(['error' => 'Please login to make a purchase'], 401);
        }

        $this->validate($request, [
            'card.number' => ['required', 'string', 'regex:/^\d{16}$/'],
            'card.expiry' => ['required', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'card.cvv' => ['required', 'string', 'regex:/^\d{3}$/'],
        ]);

        $stockData = $this->getStockData();
        $currentStock = $stockData['products'][$product->id] ?? 0;

        if($currentStock < 1) {
            return response()->json(['error' => 'Product out of stock'], 400);
        }

        try {
            DB::beginTransaction();

            // Update stock
            $stockData['products'][$product->id] = $currentStock - 1;
            $this->saveStockData($stockData);

            // Save purchase record to JSON
            $purchasesData = $this->getPurchasesData();
            $purchasesData['purchases'][] = [
                'id' => count($purchasesData['purchases']) + 1,
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'price_paid' => $product->price,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $this->savePurchasesData($purchasesData);

            DB::commit();

            return response()->json([
                'success' => true,
                'quantity' => $stockData['products'][$product->id]
            ]);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Purchase failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function purchaseHistory()
    {
        $purchasesData = $this->getPurchasesData();
        $products = Product::all()->keyBy('id');
        
        $purchases = collect($purchasesData['purchases'])
            ->filter(function($purchase) {
                return $purchase['user_id'] == auth()->id();
            })
            ->map(function($purchase) use ($products) {
                $purchase['product'] = $products[$purchase['product_id']] ?? null;
                return $purchase;
            })
            ->sortByDesc('created_at');

        return view('products.purchases', compact('purchases'));
    }
}