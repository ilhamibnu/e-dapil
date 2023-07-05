<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

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

Route::get('/', [AuthController::class, 'index'])->middleware('IsStay');
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

Route::get('/report', [CalegController::class, 'report'])->middleware('IsLogin');

Route::get('/report2', [ReportController::class, 'index'])->middleware('IsLogin');

Route::get('/kecamatan', [KecamatanController::class, 'index'])->middleware('IsLogin');
Route::post('/kecamatan', [KecamatanController::class, 'store'])->middleware('IsLogin');
Route::put('/kecamatan/{id}', [KecamatanController::class, 'update'])->middleware('IsLogin');
Route::delete('/kecamatan/{id}', [KecamatanController::class, 'delete'])->middleware('IsLogin');

Route::get('/desa', [DesaController::class, 'index'])->middleware('IsLogin');
Route::post('/desa', [DesaController::class, 'store'])->middleware('IsLogin');
Route::put('/desa/{id}', [DesaController::class, 'update'])->middleware('IsLogin');
Route::delete('/desa/{id}', [DesaController::class, 'delete'])->middleware('IsLogin');
