<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaApiController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // siswa
    Route::get('/kelas', [SiswaApiController::class, 'kelasSaya']);
    Route::get('/kelas/{id}/tugas', [SiswaApiController::class, 'tugasByKelas']);
    Route::post('/tugas/{id}/kumpulkan', [SiswaApiController::class, 'kumpulkan']);
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
