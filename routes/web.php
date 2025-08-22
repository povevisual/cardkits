<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BioLinkController;
use App\Http\Controllers\BioLinkItemController;
use App\Http\Controllers\DigitalCardController;
use App\Http\Controllers\CardTemplateController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DigitalCardPublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Public Bio Link routes
Route::get('/bio/{slug}', [App\Http\Controllers\BioLinkPublicController::class, 'show'])->name('bio.show');
Route::get('/bio/{slug}/click/{itemId}', [App\Http\Controllers\BioLinkPublicController::class, 'trackClick'])->name('bio.click');

// Public Digital Card routes
Route::get('/card/{slug}', [DigitalCardPublicController::class, 'show'])->name('digital-card.public');
Route::post('/card/{slug}/verify-password', [DigitalCardPublicController::class, 'verifyPassword'])->name('digital-card.verify-password');
Route::get('/card/{slug}/click/{componentId}', [DigitalCardPublicController::class, 'trackClick'])->name('digital-card.click');

// Include authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Bio Links
    Route::resource('bio-links', BioLinkController::class);
    Route::patch('/bio-links/{bioLink}/toggle-status', [BioLinkController::class, 'toggleStatus'])->name('bio-links.toggle-status');
    
    Route::resource('bio-link-items', BioLinkItemController::class);
    Route::patch('/bio-link-items/{bioLinkItem}/toggle-status', [BioLinkItemController::class, 'toggleStatus'])->name('bio-link-items.toggle-status');
    Route::post('/bio-link-items/reorder', [BioLinkItemController::class, 'reorder'])->name('bio-link-items.reorder');
    
    // Digital Cards
    Route::resource('digital-cards', DigitalCardController::class);
    Route::patch('/digital-cards/{digitalCard}/toggle-status', [DigitalCardController::class, 'toggleStatus'])->name('digital-cards.toggle-status');
    Route::post('/digital-cards/{digitalCard}/duplicate', [DigitalCardController::class, 'duplicate'])->name('digital-cards.duplicate');
    
    // Card Components
    Route::resource('card-components', CardComponentController::class);
    Route::patch('/card-components/{cardComponent}/toggle-status', [CardComponentController::class, 'toggleStatus'])->name('card-components.toggle-status');
    Route::post('/card-components/reorder', [CardComponentController::class, 'reorder'])->name('card-components.reorder');
    
    // Card Templates
    Route::resource('card-templates', CardTemplateController::class);
    
    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::patch('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    
    // Subscriptions
    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('/subscription-plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::post('/subscriptions/{plan}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::patch('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    
    // Admin routes (Super Admin only)
    Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/subscription-plans', [AdminController::class, 'subscription-plans'])->name('subscription-plans');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    });
});