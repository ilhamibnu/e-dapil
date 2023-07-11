<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\LandingController;

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

// landing

Route::get('/', [LandingController::class, 'index']);

Route::get('/login', [AuthController::class, 'index'])->middleware('IsStay');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('IsStay');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('IsLogin');

Route::get('/index', [DashboardController::class, 'index'])->middleware('IsLogin');
Route::get('/caleg', [CalegController::class, 'index'])->middleware('IsLogin');
Route::post('/caleg', [CalegController::class, 'store'])->middleware('IsLogin');
Route::put('/caleg/{id}', [CalegController::class, 'update'])->middleware('IsLogin');
Route::delete('/caleg/{id}', [CalegController::class, 'delete'])->middleware('IsLogin');

Route::get('/detail-kecamatan/{id}', [CalegController::class, 'detailkecamatan'])->middleware('IsLogin');
Route::post('/detail-kecamatan', [CalegController::class, 'storedetailkecamatan'])->middleware('IsLogin');
Route::put('/detail-kecamatan/{id}', [CalegController::class, 'updatedetailkecamatan'])->middleware('IsLogin');
Route::delete('/detail-kecamatan/{id}', [CalegController::class, 'deletedetailkecamatan'])->middleware('IsLogin');

Route::get('/detail-desa/{id}', [CalegController::class, 'detaildesa'])->middleware('IsLogin');
Route::post('/detail-desa', [CalegController::class, 'storedetaildesa'])->middleware('IsLogin');
Route::put('/detail-desa/{id}', [CalegController::class, 'updatedetaildesa'])->middleware('IsLogin');
Route::delete('/detail-desa/{id}', [CalegController::class, 'deletedetaildesa'])->middleware('IsLogin');

Route::get('/detail-tps/{id}', [CalegController::class, 'detailtps'])->middleware('IsLogin');
Route::post('/detail-tps', [CalegController::class, 'storedetailtps'])->middleware('IsLogin');
Route::put('/detail-tps/{id}', [CalegController::class, 'updatedetailtps'])->middleware('IsLogin');
Route::delete('/detail-tps/{id}', [CalegController::class, 'deletedetailtps'])->middleware('IsLogin');

Route::get('/detail-relawan/{id}', [CalegController::class, 'detailrelawan'])->middleware('IsLogin');
Route::post('/detail-relawan', [CalegController::class, 'storedetailrelawan'])->middleware('IsLogin');
Route::put('/detail-relawan/{id}', [CalegController::class, 'updatedetailrelawan'])->middleware('IsLogin');
Route::delete('/detail-relawan/{id}', [CalegController::class, 'deletedetailrelawan'])->middleware('IsLogin');

Route::get('/detail-pemilih/{id}', [CalegController::class, 'detailpemilih'])->middleware('IsLogin');
Route::post('/detail-pemilih', [CalegController::class, 'storedetailpemilih'])->middleware('IsLogin');
Route::put('/detail-pemilih/{id}', [CalegController::class, 'updatedetailpemilih'])->middleware('IsLogin');
Route::delete('/detail-pemilih/{id}', [CalegController::class, 'deletedetailpemilih'])->middleware('IsLogin');

// report jumlah suara caleg
Route::get('/report', [CalegController::class, 'report'])->middleware('IsLogin');
Route::get('/report3/{id}', [CalegController::class, 'report2'])->middleware('IsLogin');
Route::get('/report4/{id}', [CalegController::class, 'report3'])->middleware('IsLogin');

// report jumlah relawan caleg
Route::get('/report5', [CalegController::class, 'report4'])->middleware('IsLogin');
Route::get('/report6/{id}', [CalegController::class, 'report5'])->middleware('IsLogin');
Route::get('/report7/{id}', [CalegController::class, 'report6'])->middleware('IsLogin');

// reprt pemilih
Route::get('/report-pemilih', [CalegController::class, 'indexreportpemilih'])->middleware('IsLogin');
Route::post('/report-pemilih', [CalegController::class, 'reportpemilih'])->middleware('IsLogin');

Route::get('/tampildesa/{id}', [CalegController::class, 'tampildesa'])->middleware('IsLogin');

Route::get('/kecamatan', [KecamatanController::class, 'index'])->middleware('IsLogin');
Route::post('/kecamatan', [KecamatanController::class, 'store'])->middleware('IsLogin');
Route::put('/kecamatan/{id}', [KecamatanController::class, 'update'])->middleware('IsLogin');
Route::delete('/kecamatan/{id}', [KecamatanController::class, 'delete'])->middleware('IsLogin');

Route::get('/desa', [DesaController::class, 'index'])->middleware('IsLogin');
Route::post('/desa', [DesaController::class, 'store'])->middleware('IsLogin');
Route::put('/desa/{id}', [DesaController::class, 'update'])->middleware('IsLogin');
Route::delete('/desa/{id}', [DesaController::class, 'delete'])->middleware('IsLogin');

Route::get('/tps', [TpsController::class, 'index'])->middleware('IsLogin');
Route::post('/tps', [TpsController::class, 'store'])->middleware('IsLogin');
Route::put('/tps/{id}', [TpsController::class, 'update'])->middleware('IsLogin');
Route::delete('/tps/{id}', [TpsController::class, 'delete'])->middleware('IsLogin');
Route::get('/caridesa/{id}', [TpsController::class, 'caridesa'])->middleware('IsLogin');

Route::get('/relawan', [RelawanController::class, 'index'])->middleware('IsLogin');
Route::post('/relawan', [RelawanController::class, 'store'])->middleware('IsLogin');
Route::put('/relawan/{id}', [RelawanController::class, 'update'])->middleware('IsLogin');
Route::delete('/relawan/{id}', [RelawanController::class, 'delete'])->middleware('IsLogin');
