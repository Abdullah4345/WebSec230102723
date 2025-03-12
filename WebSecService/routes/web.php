<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebSecController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/even-numbers', function () {
    return view('even_numbers');
});
Route::get('/prime-numbers', function () {
    return view('prime_numbers');
});
Route::get('/multiplication-table', function () {
    return view('multiplication_table');
});
Route::get('/bill', function () {
    return view('bill');
});
Route::get('/transcript', function () {
    return view('Transcript');
});
Route::get('/CRUDuser', function () {
    return view('User');
});
Route::get('/CURDtable', function () {
    return view('Table');
});


Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [WebSecController::class, 'register']);

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [WebSecController::class, 'login']);
