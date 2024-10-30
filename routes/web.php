<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para Google Authentication
Route::get('/auth/google', [GoogleController::class, 'login'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::resource('usuarios', UserController::class)->except(['show']);
    Route::get('usuarios/{id}', [UserController::class, 'show'])->where('id', '[0-9]+')->name('usuarios.show');
    Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
    Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');
    Route::get('usuarios/crear', [UserController::class, 'create'])->name('usuarios.create'); 
    Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store'); 
    Route::get('pruebalayout', function(){
        return view('layouts.component-layout');
    })->name('usuarios.layouts'); 
    
    //THIS ROUTES WERE CREATED TO CHECK THE FUNCTIONALITY OF LOGIN VIEWS  --TO DELETE   :jarenas1
    Route::get('new', function(){
        return view('auth.auth-plantilla.new-password');
    })->name('auth.new'); 
    Route::get('reset', function(){
        return view('auth.auth-plantilla.reset-password');
    })->name('auth.reset'); 
    Route::get('signin', function(){
        return view('auth.auth-plantilla.sign-in');
    })->name('auth.signin'); 
    Route::get('signup', function(){
        return view('auth.auth-plantilla.sign-up');
    })->name('auth.sign'); 
    Route::get('twofactor', function(){
        return view('auth.auth-plantilla.two-factor');
    })->name('auth.twofactor'); 
});

