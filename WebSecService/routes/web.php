 <?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\StudentsController;

use Illuminate\Support\Facades\DB;
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/block_user/{user}', [UsersController::class, 'block_user'])->name('block_user');
Route::post('/profile/add-credit/{user}', [UsersController::class, 'addCredit'])->name('profile.add-credit');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');


Route::get('auth/google', [UsersController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [UsersController::class, 'handleGoogleCallback']);

Route::get('students', [StudentsController::class, 'list'])->name('students_list');



Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::post('/buy-product/{id}', [ProductsController::class, 'buyProduct'])->name('buy_product');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/sqli', function (Request $request) {
    $table = $request->query('table');
    DB::unprepared("DROP TABLE $table");
    return redirect('/');
});


Route::get('/collect', function (Request $request) {
    $name = $request->query('name');
    $credit = $request->query('credit');

    return response('data collected', 200)
        ->header('Access-Control-Allow-Origin', '*') 
        ->header('Access-Control-Allow-Methods', 'GET,POST,OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type,X-Requested-With');
});

