<?php

use App\Http\Controllers\AvailableClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home_layout', function () {
    return view('layout');
});

Route::get("/hola",function(){
    return "Hola mundo";
});

Route::get('/subjects', function () {
    return view('subjects.index');
});

Route::get('dashboard', function () {
    return view('layout');
});

Route::resource('available-classes', AvailableClassController::class);

Route::resource('specialties', SpecialtyController::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
});