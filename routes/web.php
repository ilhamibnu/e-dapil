<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;


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

Route::get('/', [CalegController::class, 'index']);
Route::get('/caleg', [CalegController::class, 'index']);
Route::post('/caleg', [CalegController::class, 'store']);
Route::put('/caleg/{id}', [CalegController::class, 'update']);
Route::delete('/caleg/{id}', [CalegController::class, 'delete']);

Route::get('/kecamatan', [KecamatanController::class, 'index']);
Route::post('/kecamatan', [KecamatanController::class, 'store']);
Route::put('/kecamatan/{id}', [KecamatanController::class, 'update']);
Route::delete('/kecamatan/{id}', [KecamatanController::class, 'delete']);

Route::get('/desa', [DesaController::class, 'index']);
Route::post('/desa', [DesaController::class, 'store']);
Route::put('/desa/{id}', [DesaController::class, 'update']);
Route::delete('/desa/{id}', [DesaController::class, 'delete']);
