<?php

use App\Http\Controllers\AdminNewsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentNewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/profil', [LandingController::class, 'tentang'])->name('profil');
Route::get('/jurusan/{slug}', [LandingController::class, 'jurusanDetail'])->name('jurusan.detail');
Route::get('/kurikulum', function () {
    return redirect(route('landing') . '#konsentrasi-keahlian');
});
Route::get('/budaya-positif', [LandingController::class, 'budayaPositif'])->name('budaya.positif');
Route::get('/ekstrakurikuler', [LandingController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
Route::get('/ekstrakurikuler/{slug}', [LandingController::class, 'ekstrakurikulerDetail'])->name('ekstrakurikuler.detail');
Route::get('/ppdb', [LandingController::class, 'ppdb'])->name('ppdb');
Route::get('/sarana-prasarana', [LandingController::class, 'saranaPrasarana'])->name('sarana.prasarana');
Route::get('/bursa-kerja-khusus', [LandingController::class, 'bursaKerjaKhusus'])->name('bursa.kerja.khusus');
Route::get('/pembelajaran', [LandingController::class, 'pembelajaran'])->name('pembelajaran');
Route::get('/kemitraan', [LandingController::class, 'kemitraan'])->name('kemitraan');
Route::get('/berita', [LandingController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [LandingController::class, 'beritaDetail'])->name('berita.detail');

Route::get('/pengumuman-kelulusan', [\App\Http\Controllers\GraduationController::class, 'index'])->name('graduation.index');
Route::post('/pengumuman-kelulusan/check', [\App\Http\Controllers\GraduationController::class, 'checkStatus'])
    ->middleware('throttle:graduation-check')
    ->name('graduation.check');

Route::prefix('siswa')->group(function () {
    Route::middleware('guest.siswa')->group(function () {
        Route::get('/login', [StudentAuthController::class, 'login'])->name('siswa.login');
        Route::post('/login', [StudentAuthController::class, 'authenticate'])->name('siswa.authenticate');
    });

    Route::middleware(['auth.siswa', 'siswa.can-submit-news'])->group(function () {
        Route::get('/berita', [StudentNewsController::class, 'index'])->name('siswa.berita.index');
        Route::get('/berita/create', [StudentNewsController::class, 'create'])->name('siswa.berita.create');
        Route::post('/berita', [StudentNewsController::class, 'store'])->name('siswa.berita.store');
        Route::get('/berita/{article}/edit', [StudentNewsController::class, 'edit'])->name('siswa.berita.edit');
        Route::put('/berita/{article}', [StudentNewsController::class, 'update'])->name('siswa.berita.update');
        Route::delete('/berita/{article}', [StudentNewsController::class, 'destroy'])->name('siswa.berita.destroy');
        Route::post('/berita/{article}/blocks', [StudentNewsController::class, 'storeBlock'])->name('siswa.berita.blocks.store');
        Route::put('/berita/{article}/blocks/{block}', [StudentNewsController::class, 'updateBlock'])->name('siswa.berita.blocks.update');
        Route::delete('/berita/{article}/blocks/{block}', [StudentNewsController::class, 'destroyBlock'])->name('siswa.berita.blocks.destroy');
        Route::post('/berita/{article}/blocks/reorder', [StudentNewsController::class, 'reorderBlocks'])->name('siswa.berita.blocks.reorder');
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('siswa.logout');
    });
});

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
        Route::post('/login', [\App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/data-kelulusan', [\App\Http\Controllers\AdminController::class, 'graduationData'])->name('admin.graduation');
        Route::post('/graduation-setting', [\App\Http\Controllers\AdminController::class, 'updateGraduationSetting'])->name('admin.graduation-setting.update');
        Route::get('/api/siswa/{id}', [\App\Http\Controllers\AdminController::class, 'apiShowSiswa'])->name('admin.api.siswa.show');
        Route::put('/api/siswa/{id}', [\App\Http\Controllers\AdminController::class, 'apiUpdateSiswa'])->name('admin.api.siswa.update');
        Route::delete('/api/siswa/{id}', [\App\Http\Controllers\AdminController::class, 'apiDeleteSiswa'])->name('admin.api.siswa.delete');
        Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
        Route::post('/import-excel', [\App\Http\Controllers\AdminController::class, 'importExcel'])->name('admin.import-excel');
        Route::post('/import-zip', [\App\Http\Controllers\AdminController::class, 'importZip'])->name('admin.import-zip');
        Route::get('/import-jobs/{uuid}', [\App\Http\Controllers\AdminController::class, 'importJobStatus'])->name('admin.import-jobs.status');
        Route::get('/php-info', function() {
            return phpinfo();
        });
        Route::get('/kelola-page', [\App\Http\Controllers\AdminController::class, 'galleryManagement'])->name('admin.gallery');
        Route::get('/ppdb-builder', [\App\Http\Controllers\AdminController::class, 'ppdbBuilder'])->name('admin.ppdb-builder');
        Route::get('/berita', [AdminNewsController::class, 'index'])->name('admin.berita.index');
        Route::get('/berita/create', [AdminNewsController::class, 'create'])->name('admin.berita.create');
        Route::post('/berita', [AdminNewsController::class, 'store'])->name('admin.berita.store');
        Route::get('/berita/{article}/edit', [AdminNewsController::class, 'edit'])->name('admin.berita.edit');
        Route::put('/berita/{article}', [AdminNewsController::class, 'update'])->name('admin.berita.update');
        Route::delete('/berita/{article}', [AdminNewsController::class, 'destroy'])->name('admin.berita.destroy');
        Route::put('/berita/highlights', [AdminNewsController::class, 'updateFeatured'])->name('admin.berita.highlights.update');
        Route::post('/berita/{article}/blocks', [AdminNewsController::class, 'storeBlock'])->name('admin.berita.blocks.store');
        Route::put('/berita/{article}/blocks/{block}', [AdminNewsController::class, 'updateBlock'])->name('admin.berita.blocks.update');
        Route::delete('/berita/{article}/blocks/{block}', [AdminNewsController::class, 'destroyBlock'])->name('admin.berita.blocks.destroy');
        Route::post('/berita/{article}/blocks/reorder', [AdminNewsController::class, 'reorderBlocks'])->name('admin.berita.blocks.reorder');
        Route::post('/kelola-page/upload-image', [\App\Http\Controllers\AdminController::class, 'uploadGalleryImage'])->name('admin.gallery.upload-image');
        Route::post('/kelola-page/home-settings', [\App\Http\Controllers\AdminController::class, 'updateHomePageSettings'])->name('admin.gallery.home-settings.update');
        Route::post('/kelola-page/page-content', [\App\Http\Controllers\AdminController::class, 'updatePageContent'])->name('admin.gallery.page-content.update');
        Route::put('/ppdb-builder/header', [\App\Http\Controllers\AdminController::class, 'updatePpdbHeader'])->name('admin.ppdb-builder.header.update');
        Route::post('/ppdb-builder/blocks', [\App\Http\Controllers\AdminController::class, 'storePpdbBlock'])->name('admin.ppdb-builder.blocks.store');
        Route::put('/ppdb-builder/blocks/{block}', [\App\Http\Controllers\AdminController::class, 'updatePpdbBlock'])->name('admin.ppdb-builder.blocks.update');
        Route::delete('/ppdb-builder/blocks/{block}', [\App\Http\Controllers\AdminController::class, 'destroyPpdbBlock'])->name('admin.ppdb-builder.blocks.destroy');
        Route::post('/ppdb-builder/blocks/reorder', [\App\Http\Controllers\AdminController::class, 'reorderPpdbBlocks'])->name('admin.ppdb-builder.blocks.reorder');
        Route::get('/template-siswa', [\App\Http\Controllers\AdminController::class, 'downloadTemplate'])->name('admin.template-siswa');
    });
});
