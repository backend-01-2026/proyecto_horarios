<?php

use App\Http\Controllers\AvailableClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home_layout', function () {
    return view('layout');
});
Route::get("/hola",function(){
    return "Hola mundo";
});

// Nuevo comentario
Route::resource('available-classes', AvailableClassController::class);
