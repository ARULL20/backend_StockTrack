<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriBarangController; 
use App\Http\Controllers\GudangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriMakananController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\KategoriMinumanController;
use App\Http\Controllers\MinumanController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;

app('router')->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/user', [AuthController::class, 'me']);

// SEMUA USER YANG LOGIN
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/kategori-barang', KategoriBarangController::class);
    Route::apiResource('/gudang', GudangController::class);
    Route::apiResource('/barang', BarangController::class);
    Route::get('/barang/stok-tipis', [BarangController::class, 'stokTipis']);
    Route::apiResource('/kategori-makanan', KategoriMakananController::class);
    Route::apiResource('/makanan', MakananController::class);
    Route::apiResource('/kategori-minuman', KategoriMinumanController::class);
    Route::apiResource('/minuman', MinumanController::class);
    Route::apiResource('/barang-keluar', BarangKeluarController::class);
    Route::post('/barang/{id}/upload-gambar', [BarangController::class, 'uploadGambar']);
});

// KHUSUS ADMIN
Route::middleware(['auth:api', 'role:admin'])->prefix('laporan')->group(function () {
    Route::get('/pemasukan', [LaporanController::class, 'readPemasukanTotal']);
    Route::get('/pengeluaran', [LaporanController::class, 'readPengeluaranTotal']);
    Route::get('/pemasukan/export', [LaporanController::class, 'exportPemasukanPDF']);
    Route::get('/pengeluaran/export', [LaporanController::class, 'exportPengeluaranPDF']);
});
