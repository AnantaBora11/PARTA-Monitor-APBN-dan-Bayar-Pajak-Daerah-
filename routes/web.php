<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PajakController;
use Illuminate\Support\Facades\Route;

// Public Route
Route::group(['middleware' => ['web']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/about', [DashboardController::class, 'updateAbout'])->name('dashboard.updateAbout');
        Route::post('/dashboard/card', [DashboardController::class, 'storeCard'])->name('dashboard.storeCard');
        Route::get('/dashboard/card/{card}/edit', [DashboardController::class, 'editCard'])->name('dashboard.editCard');
        Route::put('/dashboard/card/{card}', [DashboardController::class, 'updateCard'])->name('dashboard.updateCard');
        Route::delete('/dashboard/card/{card}', [DashboardController::class, 'deleteCard'])->name('dashboard.deleteCard');
        
        // Contact Messages
        Route::delete('/dashboard/message/{id}', [DashboardController::class, 'deleteMessage'])->name('dashboard.deleteMessage');

        // Project Routes
        Route::post('/dashboard/project', [DashboardController::class, 'storeProject'])->name('dashboard.storeProject');
        Route::get('/dashboard/project/{id}/edit', [DashboardController::class, 'editProject'])->name('dashboard.editProject');
        Route::put('/dashboard/project/{id}', [DashboardController::class, 'updateProject'])->name('dashboard.updateProject');
        Route::delete('/dashboard/project/{id}', [DashboardController::class, 'deleteProject'])->name('dashboard.deleteProject');
    });

    // Profile Routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // User Routes
    Route::middleware('user')->group(function () {
        Route::get('/pajak', [PajakController::class, 'index'])->name('pajak');
        Route::get('/pajak/check', [PajakController::class, 'checkKendaraan'])->name('pajak.check');
        Route::post('/pajak/save', [PajakController::class, 'storeSavedVehicle'])->name('pajak.save');
        Route::delete('/pajak/remove/{nopol}', [PajakController::class, 'removeSavedVehicle'])->name('pajak.remove');
        Route::post('/pajak/pay', [PajakController::class, 'getSnapToken'])->name('pajak.pay');
    });
});

// Midtrans Callback
Route::post('/midtrans/callback', [PajakController::class, 'callback'])->name('midtrans.callback');
