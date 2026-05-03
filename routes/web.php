<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/jurusan/rpl', [LandingController::class, 'jurusanDetail'])->name('jurusan.detail');
Route::get('/kurikulum', [LandingController::class, 'kurikulumDetail'])->name('kurikulum.detail');
Route::get('/budaya-positif', [LandingController::class, 'budayaPositif'])->name('budaya.positif');
Route::get('/ekstrakurikuler', [LandingController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
Route::get('/ppdb', [LandingController::class, 'ppdb'])->name('ppdb');
Route::get('/sarana-prasarana', [LandingController::class, 'saranaPrasarana'])->name('sarana.prasarana');
Route::get('/bursa-kerja-khusus', [LandingController::class, 'bursaKerjaKhusus'])->name('bursa.kerja.khusus');

Route::get('/pengumuman-kelulusan', [\App\Http\Controllers\GraduationController::class, 'index'])->name('graduation.index');
Route::post('/pengumuman-kelulusan/check', [\App\Http\Controllers\GraduationController::class, 'checkStatus'])
    ->middleware('throttle:graduation-check')
    ->name('graduation.check');

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
        Route::get('/template-siswa', [\App\Http\Controllers\AdminController::class, 'downloadTemplate'])->name('admin.template-siswa');
    });
});
