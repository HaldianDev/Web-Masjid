<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ZisController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FridayScheduleController;
use App\Http\Controllers\QurbanController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [LandingPageController::class, 'showArticle'])->name('public.articles.show');
Route::get('/jadwal-shalat', [LandingPageController::class, 'showPrayerSchedule'])->name('public.prayer-schedule');
Route::get('/agenda-kegiatan', [LandingPageController::class, 'showActivities'])->name('public.activities');
Route::get('/profil-masjid', [LandingPageController::class, 'showProfile'])->name('public.profile');
Route::get('/transparansi-kas', [LandingPageController::class, 'showFinanceTransparency'])->name('public.finance-transparency');
Route::get('/artikel-khotbah', [LandingPageController::class, 'showArticlesList'])->name('public.articles-list');
Route::get('/qurban', [LandingPageController::class, 'showQurban'])->name('public.qurban');

// Public Donation Routes
Route::post('/donation', [DonationController::class, 'store'])->name('donation.store');
Route::get('/donation/checkout/{referenceId}', [DonationController::class, 'checkout'])->name('donation.checkout');
Route::post('/donation/checkout/{referenceId}/success', [DonationController::class, 'simulateSuccess'])->name('donation.simulate-success');
Route::get('/donation/receipt/{referenceId}', [DonationController::class, 'receipt'])->name('donation.receipt');

// Admin Panel (Protected by Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Landing (Overview)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Settings (Standard Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin modules prefixed with /admin and named admin.
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Modul Informasi (Marbot & Super Admin)
        Route::middleware(['can:manage content'])->group(function () {
            Route::resource('activities', ActivityController::class);
            Route::resource('articles', ArticleController::class);
            Route::resource('friday-schedules', FridayScheduleController::class);
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        });

        // Modul Keuangan (Bendahara & Super Admin)
        Route::middleware(['can:manage finance'])->group(function () {
            Route::resource('finances', FinanceController::class);
            Route::resource('qurbans', QurbanController::class);
            Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
            Route::resource('zis', ZisController::class);
        });

        // Modul Logistik / Inventaris (Marbot, Bendahara & Super Admin)
        Route::middleware(['can:manage inventory'])->group(function () {
            Route::resource('inventory', InventoryController::class);
        });

        // Modul User & ACL (Super Admin only)
        Route::middleware(['can:manage users'])->group(function () {
            Route::resource('users', UserController::class);
        });
    });
});

require __DIR__.'/auth.php';
