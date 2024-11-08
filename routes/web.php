<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use App\Http\Middleware\VerifyRoleMiddleware;

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

Route::middleware(['role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
    Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');
});



Route::middleware(['role:admin|user'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

});


// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');
    Route::get('usuarios/crear', [UserController::class, 'create'])->name('usuarios.create'); 
    Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store'); 
    
    Route::get('twofactor', function(){return view('auth.auth-plantilla.two-factor');})->name('auth.twofactor'); 
});

// Rutas para el ¿Olvidaste tu contraseña?
Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.reset');

Route::post('reset', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('new-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('new-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Rutas para autenticación con Google 
Route::get('/auth/google', [GoogleController::class, 'login'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

//Rutas para autenticación con Github
Route::get('auth/github', [GithubController::class, 'login'])->name('github.login');

Route::get('auth/github/callback', [GithubController::class, 'callback'])->name('auth.github.callback');


// Rutas para autenticación normal
Route::post('login', [AuthController::class, 'login'])->name('login');

// Rutas para el registro
Route::get('registro', function() {return view('auth.register');})->name('registro');

Route::post('registro', [AuthController::class, 'registro'])->name('registro.submit');

