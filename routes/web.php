<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\UserLotteryController;
use App\Http\Middleware\VerifyRoleMiddleware;

// Home Route
Route::get('/', function () {
    return view('welcome');
});

Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('home', [LotteryController::class, 'index'])->name('home');
Route::get('detalles/{id}', [LotteryController::class, 'show'])->name('details');
Route::get('usuario/{id}', [UserLotteryController::class, 'getLotteriesByUserId'])->name('userpurchases');

// Google Authentication Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'login'])->name('auth.google');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

// Github Authentication Routes
Route::prefix('auth/github')->group(function () {
    Route::get('/', [GithubController::class, 'login'])->name('github.login');
    Route::get('/callback', [GithubController::class, 'callback'])->name('auth.github.callback');
});


// Authenticated Routes (Protected by Auth Middleware)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('twofactor', function () { return view('auth.auth-plantilla.two-factor'); })->name('auth.twofactor'); 
    
    Route::post('/usuarios/lotteries/assign-number', [UserLotteryController::class, 'buyLottery'])->name('assign.number');
    
    Route::middleware(['role:admin|organizador'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
        Route::resource('lotteries', LotteryController::class);
    });
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
        Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');
        Route::resource('roles', RoleController::class);
        Route::resource('permisos', PermissionController::class);
    });
});
Route::resource('usuarios', UserController::class);

// Password Reset Routes
Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.email');
Route::get('new-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('auth.password.reset');
Route::post('new-password', [ResetPasswordController::class, 'reset'])->name('auth.password.update');


// Registration Routes
Route::get('registro', function () { return view('auth.register'); })->name('registro');
Route::post('registro', [AuthController::class, 'registro'])->name('registro.submit');
