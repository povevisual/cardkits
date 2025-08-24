<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BioLinkController;
use App\Http\Controllers\BioLinkItemController;
use App\Http\Controllers\BioLinkPublicController;

Route::get('/', function () {
    return view('welcome');
});

// Bio Link Public Routes
Route::get('/bio/{slug}', [BioLinkPublicController::class, 'show'])->name('bio.public');
Route::get('/bio/{slug}/click/{itemId}', [BioLinkPublicController::class, 'trackClick'])->name('bio.click');

// Protected Bio Link Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('bio-links', BioLinkController::class);
    Route::resource('bio-link-items', BioLinkItemController::class);
    
    // Additional bio link routes
    Route::patch('/bio-links/{bioLink}/toggle-status', [BioLinkController::class, 'toggleStatus'])->name('bio-links.toggle-status');
    
    // Bio link items management
    Route::post('/bio-links/{bioLink}/items/reorder', [BioLinkItemController::class, 'reorder'])->name('bio-link-items.reorder');
    Route::post('/bio-links/{bioLink}/items/toggle-status', [BioLinkItemController::class, 'toggleStatus'])->name('bio-link-items.toggle-status');
});

require __DIR__.'/auth.php';
