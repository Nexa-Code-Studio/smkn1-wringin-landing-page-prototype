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
