<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use App\Http\Middleware\VerifyRoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para Google Authentication
Route::get('/auth/google', [GoogleController::class, 'login'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

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

Route::middleware([VerifyRoleMiddleware::class, 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
    Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');
});



Route::middleware([VerifyRoleMiddleware::class, 'role:user'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});


// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    //Route::get('usuarios/{id}', [UserController::class, 'show'])->where('id', '[0-9]+')->name('usuarios.show');

    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

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

Route::prefix('admin')->middleware('role:admin')->group(function(){
    
});

Route::group(['middleware' => ['role:admin']], function () { 
    
 });