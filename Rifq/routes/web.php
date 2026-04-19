<?php

use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'landing'])->name('landing');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/team', [PageController::class, 'team'])->name('pages.team');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/language/{locale}', [PageController::class, 'switchLang'])->name('language.switch');
Route::get('/public/animals/{uuid}', [AnimalController::class, 'showPublic'])->name('animals.public-view');

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/request-team-upgrade', [ProfileController::class, 'requestTeamUpgrade'])->name('request-team-upgrade');
    });

    Route::middleware(['role:admin|data_entry|vet'])->group(function () {
        Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
        Route::get('/animals/data-entry/{animal}', [AnimalController::class, 'edit'])
            ->middleware('pet.data_entry_access')
            ->name('animals.data-entry');
        Route::post('/animals/save-data', [AnimalController::class, 'storeOrUpdate'])->name('animals.store-or-update');
        Route::get('/animals/show/{uuid}', [AnimalController::class, 'show'])->name('animals.show');
        Route::delete('/animals/{uuid}', [AnimalController::class, 'destroy'])->name('animals.destroy');
        Route::post('/animals/bulk-destroy', [AnimalController::class, 'bulkDestroy'])->name('animals.bulk-destroy');

        Route::get('/qrcodes/generate', [AnimalController::class, 'showQRGenerationForm'])->name('qrcodes.generate.form');
        Route::post('/qrcodes/generate', [AnimalController::class, 'generateQRCodes'])->name('qrcodes.generate.submit');
        Route::post('/qrcodes/print-pdf', [AnimalController::class, 'printQRCodes'])->name('qrcodes.print.pdf');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('trash', [AnimalController::class, 'trashIndex'])->name('trash.index');
        Route::post('trash/{id}/restore', [AnimalController::class, 'trashRestore'])->name('trash.restore');
        Route::delete('trash/{id}/delete', [AnimalController::class, 'trashDestroy'])->name('trash.destroy');
    });

    Route::get('/adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
    Route::get('/adoptions/{animal}', [AdoptionController::class, 'show'])->name('adoptions.show');
    Route::post('/adoptions/{animal}/request', [AdoptionController::class, 'submitRequest'])->name('adoptions.submit');
    Route::get('/my-requests', [AdoptionController::class, 'myRequests'])->name('adoptions.my-requests');
});

Route::get('/scan/{hash}', [QRController::class, 'show'])->name('qr.show');

require __DIR__ . '/auth.php';
