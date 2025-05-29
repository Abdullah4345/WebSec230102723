<?php
namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artisan;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller {

    public function login(Request $request) {

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return response()->json(['error' => 'Invalid login info.'], 401);
        }

        $user = User::where('email', $request->email)
        ->select('id', 'name', 'email')->first();

        $token = $user->createToken('app');

        return response()->json(['token'=>$token->accessToken, 'user'=>$user->getAttributes()]);
    }

    public function users(Request $request) {

        $users = User::select('id', 'name', 'email')->get()->toArray();

        return response()->json(['users'=>$users]);
    }

    public function logout(Request $request) { }
}
