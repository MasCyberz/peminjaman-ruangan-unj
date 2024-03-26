<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\KepalaUptController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\UserController;

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
    return redirect()->route('login');
});

// LOGIN / LOGOUT
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticating'])->name('authenticating')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'khusus_admin'])->group(function () {
    Route::get('admin/', [SuratController::class, 'index'])->name('home');

    // Alur Untuk Surat
    Route::get('admin/peminjaman', [SuratController::class, 'peminjaman'])->name('peminjaman');
    Route::get('admin/surat_tambah', [SuratController::class, 'create_peminjaman'])->name('surat_tambah');
    Route::post('admin/surat_store', [SuratController::class, 'store_peminjaman'])->name('surat_store');
    Route::get('admin/surat_delete/{id}', [SuratController::class, 'destroy'])->name('surat_delete');
    Route::get('admin/edit_surat/{id}', [SuratController::class, 'edit'])->name('edit_surat');
    Route::put('admin/surat_update/{id}', [SuratController::class, 'update'])->name('update_surat');
    
    // Untuk Data Referensi
    Route::get('admin/data-referensi', [RuanganController::class, 'index'])->name('data-referensi');
    Route::get('admin/tambah-referensi', [RuanganController::class, 'create'])->name('tambah_ruangan');
    Route::post('admin/tambah-referensi/store', [RuanganController::class, 'store'])->name('ruangan_store');
    Route::get('admin/edit-referensi/{id}', [RuanganController::class, 'edit'])->name('edit_ruangan');
    Route::put('admin/data-referensi/store/{id}', [RuanganController::class, 'update'])->name('ruangan_update');
    Route::delete('admin/data-referensi/destroy/{id}', [RuanganController::class, 'destroy'])->name('delete_ruangan');

    // Mengatur PDF
    Route::get('admin/pdf/{surat_id}', [SuratController::class, 'bikinPDF'])->name('pdf');
    Route::view('admin/surat_balasan', 'pdf.surat_balasan')->name('surat_balasan');

    // Management Users
    Route::get('admin/users', [UserController::class, 'index'])->name('management-users');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('management-users-create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name('management-users-store');
    Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('management-users-edit');
    Route::put('admin/users/update/{id}', [UserController::class, 'update'])->name('management-users-update');
    Route::delete('admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('management-user-destroy');
});

Route::middleware(['auth', 'khusus_ka'])->group(function () {
    // Home
    Route::get('kepala-upt/', [KepalaUptController::class, 'index'])->name('home_kepala_upt');

    // Peminjaman
    Route::get('kepala-upt/peminjaman', [KepalaUptController::class, 'peminjaman'])->name('peminjaman_kepala_upt');
    Route::get('kepala-upt/peminjaman-detail/{id}', [KepalaUptController::class, 'show_peminjaman'])->name('detail_peminjaman_kepala_upt');
    Route::put('kepala-upt/peminjaman-detail/{id}/respond', [KepalaUptController::class, 'respond'])->name('respond_kepala_upt');

    // Kalender
    Route::get('kepala-upt/kalender', [KepalaUptController::class, 'kalender'])->name('kalender_kepala_upt');
    Route::get('/cobaFullCalendar', [KepalaUptController::class, 'cobaFullCalendar'])->name('cobaFullCalendar');
});

Route::middleware(['auth', 'khusus_jaringan'])->group(function () {
    // Home
    Route::get('/jaringan', [JaringanController::class, 'index'])->name('home_jaringan');

    // Request ruang yang tersedia
    Route::get('/jaringan/peminjaman', [JaringanController::class, 'table_peminjaman'])->name('peminjaman_jaringan');
    Route::get('/jaringan/data_referensi', [JaringanController::class, 'data_referensi'])->name('referensi_jaringan');
    Route::get('/jaringan/detail-surat/{id}', [JaringanController::class, 'show_detail'])->name('detail_surat_jaringan');
    Route::get('/jaringan/ajukan-peminjaman/{id}', [JaringanController::class, 'ajukanPeminjaman'])->name('ajukan_peminjaman_jaringan');
    // Route::post('/jaringan/ajukan-peminjaman/{suratId}/store', [JaringanController::class, 'ajukanPeminjamanStore'])->name('ajukan_peminjaman_store');
    Route::post('/jaringan/ajukan-peminjaman/store/{suratId}', [JaringanController::class, 'ajukanPeminjamanStore'])->name('ajukan_peminjaman_store');
});

Route::middleware(['auth', 'khusus_koordinator'])->group(function () {
    // Home
    Route::get('/koordinator', [KoordinatorController::class, 'index'])->name('home_koordinator');

    // Penerima/Penolakan Ruangan
    Route::get('/koordinator/pengajuan', [KoordinatorController::class, 'pengajuan'])->name('pengajuan_koordinator');
    // Route::post('/koordinator/pengajuan/store/{suratId}/{ruanganId}', [KoordinatorController::class, 'pengajuan_store'])->name('pengajuan_store_koordinator');
    Route::post('/koordinator/pengajuan/store/{suratId}/', [KoordinatorController::class, 'pengajuan_store'])->name('pengajuan_store_koordinator');
    route::get('/koordinator/data_referensi', [KoordinatorController::class, 'data_referensi'])->name('referensi_koordinator');
});
