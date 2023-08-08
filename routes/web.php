<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\GuestsController;
use App\Http\Controllers\CategoryDescriptionController;
use App\Http\Controllers\Api\Mahasiswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GuestsController::class, 'index']);
Route::get('/mahasiswa/{nim}', [Mahasiswa::class, 'getMahasiswa']);

Route::post('/', [GuestsController::class, 'store']);
Route::put('/{guest}', [GuestsController::class, 'update']);
Route::delete('/{guest}', [GuestsController::class, 'destroy']);
Route::get('/export-data', [GuestsController::class, 'exportData']);
Route::post('/export-data', [GuestsController::class, 'exportData']);
Route::get('category-description', [CategoryDescriptionController::class, 'index']);
Route::post('category-description', [CategoryDescriptionController::class, 'store']);
Route::put('category-description/{categoryDescription}', [CategoryDescriptionController::class, 'update']);
Route::delete('category-description/{categoryDescription}', [CategoryDescriptionController::class, 'destroy']);


Route::get('/analytics', [AnalyticsController::class, 'index']);
Route::post('/analytics/{group_by}', [AnalyticsController::class, 'categoryAnalytics']);
