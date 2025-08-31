<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AnalyticsController;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Load auth routes first, before catch-all routes
require __DIR__.'/auth.php';
require __DIR__.'/settings.php';

// Protected routes - must come before catch-all routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile management
    Route::prefix('dashboard/profile')->name('dashboard.profile.')->group(function () {
        Route::get('/', [DashboardController::class, 'profileSettings'])->name('index');
        Route::put('/', [DashboardController::class, 'updateProfile'])->name('update');
    });
    
    // Link management
    Route::prefix('dashboard/links')->name('dashboard.links.')->group(function () {
        Route::get('/', [LinkController::class, 'index'])->name('index');
        Route::post('/', [LinkController::class, 'store'])->name('store');
        Route::put('/{link}', [LinkController::class, 'update'])->name('update');
        Route::delete('/{link}', [LinkController::class, 'destroy'])->name('destroy');
        Route::patch('/{link}/toggle', [LinkController::class, 'toggle'])->name('toggle');
        Route::post('/reorder', [LinkController::class, 'reorder'])->name('reorder');
    });
    
    // Portfolio management
    Route::prefix('dashboard/portfolio')->name('dashboard.portfolio.')->group(function () {
        Route::get('/', [DashboardController::class, 'portfolio'])->name('index');
        Route::post('/', [DashboardController::class, 'storePortfolio'])->name('store');
        Route::put('/{portfolio}', [DashboardController::class, 'updatePortfolio'])->name('update');
        Route::delete('/{portfolio}', [DashboardController::class, 'destroyPortfolio'])->name('destroy');
    });
    
    // Analytics
    Route::prefix('dashboard/analytics')->name('dashboard.analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/data', [AnalyticsController::class, 'getData'])->name('data');
    });
    
    // Theme management
    Route::prefix('dashboard/themes')->name('dashboard.themes.')->group(function () {
        Route::get('/', [DashboardController::class, 'themes'])->name('index');
        Route::post('/{theme}/apply', [DashboardController::class, 'applyTheme'])->name('apply');
        Route::put('/customize', [DashboardController::class, 'customizeTheme'])->name('customize');
    });
});

// Public profile routes (these MUST be last as they are catch-all)
Route::get('/{slug}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/link/redirect/{linkId}', [ProfileController::class, 'redirectLink'])->name('link.redirect');
Route::get('/portfolio/track/{portfolioId}', [ProfileController::class, 'trackPortfolioView'])->name('portfolio.track');
Route::get('/qr/{slug}', [ProfileController::class, 'generateQrCode'])->name('qr.generate');
