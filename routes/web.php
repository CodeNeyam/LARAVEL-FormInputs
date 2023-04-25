<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormDataController;

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
// Store the data route
Route::post('/form-data', [FormDataController::class, 'store']);

// Download the data route
Route::get('/form-data/{id}/download', [FormDataController::class, 'download']);

// Download all the data
Route::get('/form-data/download-all', [FormDataController::class, 'downloadAll']);

// Import the data from CSV file
Route::post('/form-data/import', [FormDataController::class, 'import']);

// Form
Route::get('/form', function () {
    return view('form');
});

