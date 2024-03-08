<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\KepalaUptController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\RuanganController;

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
Route::get('admin/data-referensi', [RuanganController::class, 'index'])->name('data-referensi');
Route::get('admin/tambah-referensi', [RuanganController::class, 'create'])->name('tambah_ruangan');
Route::post('admin/tambah-referensi/store', [RuanganController::class, 'store'])->name('ruangan_store');
Route::get('admin/edit-referensi/{id}', [RuanganController::class, 'edit'])->name('edit_ruangan');
Route::put('admin/data-referensi/store/{id}', [RuanganController::class, 'update'])->name('ruangan_update');
Route::delete('admin/data-referensi/destroy/{id}', [RuanganController::class, 'destroy'])->name('delete_ruangan');

Route::get('kepala-upt/', [KepalaUptController::class, 'index'])->name('home_kepala_upt');
Route::get('kepala-upt/peminjaman', [KepalaUptController::class, 'peminjaman'])->name('peminjaman_kepala_upt');
Route::get('kepala-upt/peminjaman-detail/{id}' , [KepalaUptController::class, 'show_peminjaman'])->name('detail_peminjaman_kepala_upt');
Route::put('kepala-upt/peminjaman-detail/{id}/respond' , [KepalaUptController::class, 'respond'])->name('respond_kepala_upt');

Route::get('/jaringan', [ JaringanController::class, 'index'] )->name('home_jaringan');
Route::get('/jaringan/peminjaman', [JaringanController::class, 'table_peminjaman'])->name('peminjaman_jaringan');
Route::get('/jaringan/data_referensi', [JaringanController::class, 'data_referensi'])->name('referensi_jaringan');
Route::get('/jaringan/detail-surat/{id}', [JaringanController::class, 'show_detail'])->name('detail_surat_jaringan');
Route::get('/jaringan/ajukan-peminjaman/{id}', [JaringanController::class, 'ajukanPeminjaman'])->name('ajukan_peminjaman_jaringan');
// Route::post('/jaringan/ajukan-peminjaman/{suratId}/store', [JaringanController::class, 'ajukanPeminjamanStore'])->name('ajukan_peminjaman_store');
Route::post('/jaringan/ajukan-peminjaman/store/{suratId}', [JaringanController::class, 'ajukanPeminjamanStore'])->name('ajukan_peminjaman_store');


Route::get('/koordinator', [KoordinatorController::class, 'index'])->name('home_koordinator');
Route::get('/koordinator/pengajuan', [KoordinatorController::class, 'pengajuan'])->name('pengajuan_koordinator');
// Route::post('/koordinator/pengajuan/store/{suratId}/{ruanganId}', [KoordinatorController::class, 'pengajuan_store'])->name('pengajuan_store_koordinator');
Route::post('/koordinator/pengajuan/store/{suratId}/', [KoordinatorController::class, 'pengajuan_store'])->name('pengajuan_store_koordinator');
route::get('/koordinator/data_referensi', [KoordinatorController::class, 'data_referensi'])->name('referensi_koordinator');
