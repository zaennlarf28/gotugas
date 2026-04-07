<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\TugasController;
use App\Http\Controllers\Api\ChatController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Kelas
    Route::get('/kelas',                [KelasController::class, 'index']);
    Route::get('/kelas/{id}',           [KelasController::class, 'show']);
    Route::post('/kelas/join',          [KelasController::class, 'join']);
    Route::delete('/kelas/{id}/keluar', [KelasController::class, 'keluar']);

    // Tugas
    Route::get('/tugas/{id}',            [TugasController::class, 'show']);
    Route::post('/tugas/{id}/kumpulkan', [TugasController::class, 'kumpulkan']);

    // Chat Kelas
    Route::get('/chat/kelas/{kelasId}',        [ChatController::class, 'kelasMessages']);
    Route::post('/chat/kelas/{kelasId}',       [ChatController::class, 'kelasSend']);
    Route::get('/chat/kelas/{kelasId}/poll',   [ChatController::class, 'pollKelas']);
    Route::post('/chat/kelas/{kelasId}/balas', [ChatController::class, 'balasPesanKelas']);

    // Chat DM
    Route::get('/chat/dm/{userId}',        [ChatController::class, 'dmMessages']);
    Route::post('/chat/dm/{userId}',       [ChatController::class, 'dmSend']);
    Route::get('/chat/dm/{userId}/poll',   [ChatController::class, 'pollDm']);
    Route::post('/chat/dm/{userId}/balas', [ChatController::class, 'balasPesanDm']);

    // Edit & Hapus pesan
    Route::put('/chat/pesan/{id}',    [ChatController::class, 'editPesan']);
    Route::delete('/chat/pesan/{id}', [ChatController::class, 'hapusPesan']);
});