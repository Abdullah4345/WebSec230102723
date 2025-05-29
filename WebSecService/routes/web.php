<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\GradesController;
use App\Http\Controllers\Web\CoursesController;
use App\Http\Controllers\Web\UsersController;

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
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::get('/auth/google', 
[UsersController::class, 'redirectToGoogle'])
->name('login_with_google');

Route::get('/auth/google/callback', 
[UsersController::class, 'handleGoogleCallback']);



Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('grades', [GradesController::class, 'list'])->name('grades_list');
Route::get('grades/edit/{grade?}', [GradesController::class, 'edit'])->name('grades_edit');
Route::post('grades/save/{grade?}', [GradesController::class, 'save'])->name('grades_save');
Route::get('grades/delete/{grade}', [GradesController::class, 'delete'])->name('grades_delete');

Route::get('courses', [CoursesController::class, 'list'])->name('courses_list');
Route::get('courses/edit/{course?}', [CoursesController::class, 'edit'])->name('courses_edit');
Route::post('courses/save/{course?}', [CoursesController::class, 'save'])->name('courses_save');
Route::get('courses/delete/{course}', [CoursesController::class, 'delete'])->name('courses_delete');

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

Route::get('/cryptography', function (Request $request) {

    $data = $request->data??"Welcome to Cryptography";
    $action = $request->action??"Encrypt";
    $result = $request->result??"";
    $status = "Failed";
    $size = 0;

    if($request->action=="Encrypt") {

        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }
    }
    else if($request->action=="Decrypt") {

        $temp = base64_decode($request->data);

        $result = openssl_decrypt($temp, 'aes-128-ecb',  'thisisasecretkey', OPENSSL_RAW_DATA, '');

        if($result) $status = 'Decrypted Successfully';
    }
    else if($request->action=="Hash") {

        $temp = hash('sha256', $request->data);

        $result = base64_encode($temp);

        $status = 'Hashed Successfully';
    }
    else if($request->action=="Sign") {

        $path = storage_path('app/private/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];

        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];

        $signature = '';
        if(openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
            $result = base64_encode($signature);
            $status = 'Signed Successfully';
        }
    }
    else if($request->action=="Verify") {

        $signature = base64_decode($request->result);

        $path = storage_path('app/public/useremail@domain.com.crt');
        $publicKey = file_get_contents($path);

        if(openssl_verify($request->data, $signature, $publicKey, 'sha256')) {
            $status = 'Verified Successfully';
        }
    }
    else if($request->action=="KeySend") {

        $path = storage_path('app/public/useremail@domain.com.crt');
        $publicKey = file_get_contents($path);
        $temp = '';

        if(openssl_public_encrypt($request->data, $temp, $publicKey)) {
            $result = base64_encode($temp);
            $status = 'Key is Encrypted Successfully';
        }
    }
    else if($request->action=="KeyRecive") {

        $path = storage_path('app/private/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];

        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];

        $encryptedKey = base64_decode($request->data);
        $result = '';

        if(openssl_private_decrypt($encryptedKey, $result, $privateKey)) {

            $status = 'Key is Decrypted Successfully';
        }
    }





    return view('cryptography', compact('data', 'result', 'action', 'status'));
})->name('cryptography');

