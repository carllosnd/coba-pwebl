<?php

use App\Http\Controllers\CobaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    echo "Hello world";
});

Route::get('/test/{nama}/{umur}', function ($nama, $umur) {
    echo "Hello World " . $nama . ' ' . $umur;
});

Route::get('produk/baru', function () {
    echo "Ini adalah halaman produk";
});

Route::get('/coba',[CobaController::class,'index']);
Route::get('/coba/lagi', [CobaController::class,'testing']);
Route::get('/coba/view', [CobaController::class,'cobaview']);
Route::get('/coba/model', [CobaController::class,'cobaModel']);
Route::get('/coba/mvc', [CobaController::class,'cobaMVC']);
