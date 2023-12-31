<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapperController;
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
Route::get('/scrapper', [ScrapperController::class, 'scrapper']);
Route::get('/scrapperSaveData', [ScrapperController::class, 'scrapperSaveData']);
Route::get('/clearStoredData', [ScrapperController::class, 'clearStoredData']);
Route::get('/', function () {
    return view('welcome');
});
