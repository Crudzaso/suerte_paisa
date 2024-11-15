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

Route::get('/', function () {
    return redirect()->route('lotteries.index');
});

// Loterías
Route::get('detalles/{id}', [LotteryController::class, 'show'])->name('lotteries.show');
Route::get('usuario/{id}', [UserLotteryController::class, 'getLotteriesByUserId'])->name('userpurchases');

// Dashboard de Loterías
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard-loterias', [DashboardController::class, 'lottery'])->name('dashboard.lottery');

// Dashboard de Usuarios
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard-usuarios', [DashboardController::class, 'users'])->name('dashboard.users');

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

// User Routes
Route::resource('usuarios', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permisos', PermissionController::class);

// Authenticated Routes (Protected by Auth Middleware)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Rutas generales protegidas
    Route::get('/dashboard/loterias', [DashboardController::class, 'lottery'])->name('dashboard.lottery');
    Route::get('/dashboard/usuarios', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::post('logout', [GoogleController::class, 'logout'])->name('logout');

    // Rutas exclusivas para admins
    Route::middleware(['role:admin'])->group(function () {
        // Rutas de Usuarios
        Route::get('usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
        Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
        Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');

        Route::get('loterias', [LotteryController::class, 'index'])->name('loterias.index');
        Route::get('loterias/eliminadas', [LotteryController::class, 'trashed'])->name('loterias.trashed');
        Route::get('loterias/crear', [LotteryController::class, 'create'])->name('loterias.create');
        Route::post('loterias', [LotteryController::class, 'store'])->name('loterias.store');
        Route::get('loterias/{id}', [LotteryController::class, 'show'])->name('loterias.show');
        Route::get('loterias/{id}/editar', [LotteryController::class, 'edit'])->name('loterias.edit');
        Route::put('loterias/{id}', [LotteryController::class, 'update'])->name('loterias.update');
        Route::delete('loterias/{id}', [LotteryController::class, 'destroy'])->name('loterias.destroy');
        Route::post('loterias/{id}/restaurar', [LotteryController::class, 'restore'])->name('loterias.restore');
    });
});



// Password Reset Routes
Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.reset');
Route::post('reset', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('new-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('new-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Registration Routes
Route::get('registro', function () { return view('auth.register'); })->name('registro');
Route::post('registro', [AuthController::class, 'registro'])->name('registro.submit');

