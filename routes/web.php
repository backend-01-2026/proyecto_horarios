<?php

use App\Http\Controllers\AvailableClassController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TimeSlotController;
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
Route::resource('semesters', SemesterController::class);
Route::resource('specialties', SpecialtyController::class);
Route::resource('time-slots', TimeSlotController::class);

Route::resource('specialties', SpecialtyController::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
});
