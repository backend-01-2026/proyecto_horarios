<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Route::get("/hola",function(){
    return "Hola mundo";
});

Route::get('/subjects', function () {
    return view('subjects.index');
});


// Nuevo comentario