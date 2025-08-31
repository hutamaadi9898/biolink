<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Stop impersonating (accessible to impersonated users, only auth required)
Route::middleware(['auth'])->post('/admin/stop-impersonating', [UsersController::class, 'stopImpersonating'])->name('admin.stop-impersonating');

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/system', [AdminController::class, 'system'])->name('system');
    
    // Users management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/{user}', [UsersController::class, 'show'])->name('show');
        Route::put('/{user}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-admin', [UsersController::class, 'toggleAdmin'])->name('toggle-admin');
        Route::post('/{user}/toggle-verification', [UsersController::class, 'toggleVerification'])->name('toggle-verification');
        Route::post('/{user}/impersonate', [UsersController::class, 'impersonate'])->name('impersonate');
    });
    
    // Links management
    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/', [LinksController::class, 'index'])->name('index');
        Route::get('/{link}', [LinksController::class, 'show'])->name('show');
        Route::put('/{link}', [LinksController::class, 'update'])->name('update');
        Route::delete('/{link}', [LinksController::class, 'destroy'])->name('destroy');
        Route::post('/{link}/toggle-visibility', [LinksController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/bulk-action', [LinksController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::post('/export', [AnalyticsController::class, 'export'])->name('export');
        Route::post('/cleanup', [AnalyticsController::class, 'cleanup'])->name('cleanup');
    });
});
