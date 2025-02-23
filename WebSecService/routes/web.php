<?php

use Illuminate\Support\Facades\Route;

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