<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [\App\Http\Controllers\QuotationDataController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('index');

Route::post('/estimations', [\App\Http\Controllers\QuotationDataController::class,'store'])
    ->middleware(['auth', 'verified'])->name('estimations.store');

Route::get('/estimations', [\App\Http\Controllers\QuotationDataController::class,'form'])
    ->middleware(['auth', 'verified'])->name('estimations.form');;

Route::get('/show/{id}', [\App\Http\Controllers\QuotationDataController::class,'show'])
    ->middleware(['auth', 'verified'])->name('estimations.show');;

Route::get('/edit/{id}', [\App\Http\Controllers\QuotationDataController::class,'edit'])
    ->middleware(['auth', 'verified'])->name('estimations.edit');

Route::put('/estimations', [\App\Http\Controllers\QuotationDataController::class,'update'])
    ->middleware(['auth', 'verified'])->name('estimations.update');

Route::post('/estimations/send', [\App\Http\Controllers\QuotationDataController::class,'send'])
    ->middleware(['auth', 'verified'])->name('estimations.send');

Route::post('/xls', [\App\Http\Controllers\XlsController::class,'download'])
    ->middleware(['auth', 'verified'])->name('xlsx.download');

require __DIR__.'/auth.php';
