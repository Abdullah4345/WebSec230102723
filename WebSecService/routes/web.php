<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebSecController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/home');
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

Route::get('/logout', [WebSecController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return view('home');
});

Route::resource('students', StudentController::class);
Route::resource('grades', GradeController::class);
Route::resource('users', UserController::class);
