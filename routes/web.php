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

Route::group(['middleware' => 'prevent-back-button'],function(){
    Route::get('/estimations/{step}', 'HomeController@index');
});

//User
Route::get('/', [\App\Http\Controllers\QuotationDataController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('quotation_data.index');

//QuotationData
Route::post('/estimations', [\App\Http\Controllers\QuotationDataController::class,'store'])
    ->middleware(['auth', 'verified'])->name('quotation_data.store');
Route::get('/estimations/{step}', [\App\Http\Controllers\QuotationDataController::class,'form'])
    ->middleware(['auth', 'verified'])->name('quotation_data.form');;
Route::post('/estimations/edit', [\App\Http\Controllers\QuotationDataController::class,'edit'])
    ->middleware(['auth', 'verified'])->name('quotation_data.edit');
Route::post('/estimations/verify', [\App\Http\Controllers\QuotationDataController::class,'verify'])
    ->middleware(['auth', 'verified'])->name('quotation_data.verify');
Route::get('/show/{id}', [\App\Http\Controllers\QuotationDataController::class,'show'])
    ->middleware(['auth', 'verified'])->name('quotation_data.show');;
//Route::get('/edit/{id}', [\App\Http\Controllers\QuotationDataController::class,'edit'])
//    ->middleware(['auth', 'verified'])->name('quotation_data.edit');
Route::put('/estimations', [\App\Http\Controllers\QuotationDataController::class,'update'])
    ->middleware(['auth', 'verified'])->name('quotation_data.update');
Route::post('/estimations/send', [\App\Http\Controllers\QuotationDataController::class, 'dispatch'])
    ->middleware(['auth', 'verified'])->name('quotation_data.dispatch');
Route::post('/delete/', [\App\Http\Controllers\QuotationDataController::class,'delete'])
    ->middleware(['auth', 'verified'])->name('quotation_data.delete');

//Files
Route::post('/xls', [\App\Http\Controllers\XlsController::class,'download'])
    ->middleware(['auth', 'verified'])->name('xlsx.download');
Route::post('/docx', [\App\Http\Controllers\DocxController::class,'download'])
    ->middleware(['auth', 'verified'])->name('docx.download');

require __DIR__.'/auth.php';
