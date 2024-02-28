<?php

use App\Http\Controllers\KepalaUptController;
use App\Http\Controllers\SuratController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/', [SuratController::class, 'index'])->name('home');
Route::get('admin/peminjaman', [SuratController::class, 'peminjaman'])->name('peminjaman');
Route::get('admin/surat_tambah' , [SuratController::class, 'create_peminjaman'])->name('surat_tambah');
Route::post('admin/surat_store' , [SuratController::class, 'store_peminjaman'])->name('surat_store');
Route::get('admin/surat_delete/{id}' , [SuratController::class, 'destroy'])->name('surat_delete');

Route::get('kepala-upt/', [KepalaUptController::class, 'index'])->name('home_kepala_upt');
Route::get('kepala-upt/peminjaman', [KepalaUptController::class, 'peminjaman'])->name('peminjaman_kepala_upt');
Route::get('kepala-upt/peminjaman-detail/{id}' , [KepalaUptController::class, 'show_peminjaman'])->name('detail_peminjaman_kepala_upt');
Route::put('kepala-upt/peminjaman-detail/{id}/respond' , [KepalaUptController::class, 'respond'])->name('respond_kepala_upt');
