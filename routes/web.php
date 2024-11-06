<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para autenticación con Google 
Route::get('/auth/google', [GoogleController::class, 'login'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

//Rutas para autenticación con Github
Route::get('auth/github', [GithubController::class, 'login'])->name('github.login');

Route::get('auth/github/callback', [GithubController::class, 'callback'])->name('auth.github.callback');


Route::prefix('auth')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

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

