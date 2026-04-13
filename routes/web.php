<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfilController;

use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MapelController;
use App\Http\Controllers\Backend\ClassController;

use App\Http\Controllers\Guru\CobaController;
use App\Http\Controllers\Guru\TugasController;

use App\Http\Controllers\Siswa\TugasController as SiswaTugasController;
use App\Http\Controllers\Siswa\ChatController;
use App\Http\Controllers\SiswaKelasController;

use App\Http\Middleware\Admin;
use App\Http\Middleware\Guru;
use App\Http\Middleware\Siswa;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index']);
Route::get('/join', function () {
return view('join');
})->name('join');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');

Route::group(['prefix'=>'admin', 'as' => 'backend.', 'middleware'=>['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('dashboard');
    // crud
    Route::resource('/users', UserController::class);
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/mapel', MapelController::class);
    Route::resource('/classes', ClassController::class);

    Route::resource('guru', \App\Http\Controllers\Backend\GuruController::class);
    Route::resource('siswa', \App\Http\Controllers\Backend\SiswaController::class);
});

Route::group(['prefix'=>'guru', 'as' => 'guru.', 'middleware'=>['auth', Guru::class]], function () {
    Route::get('/', [GuruController::class, 'index'])->name('dashboard');

    // Kelas
    Route::resource('kelas', \App\Http\Controllers\Guru\KelasController::class);
    
    Route::resource('mapel', MapelController::class);
    Route::resource('coba', CobaController::class);

    // ── Tugas ──
    // Resource sudah generate: index, show, edit, update, destroy, create (default)
    // Tapi create butuh kelas parameter, jadi kita override + tambah custom routes
    Route::resource('tugas', \App\Http\Controllers\Guru\TugasController::class)
        ->except(['create', 'store']); // override 2 ini secara manual

    Route::get('kelas/{kelas}/tugas/create', [TugasController::class, 'create'])
        ->name('tugas.create');
    Route::post('kelas/{kelas}/tugas', [TugasController::class, 'store'])
        ->name('tugas.store');

    // Nilai pengumpulan
    Route::put('tugas/pengumpulan/{id}/nilai', [TugasController::class, 'beriNilai'])
        ->name('tugas.nilai');

    // Lihat pengumpulan per tugas
    Route::get('tugas/{tugas}/pengumpulan', [TugasController::class, 'lihatPengumpulan'])
        ->name('tugas.pengumpulan');
});

Route::middleware(['auth', Siswa::class])->prefix('siswa')->name('siswa.')->group(function () {
         
    Route::get('/', [SiswaKelasController::class, 'index'])->name('index');
    // Join kelas
    Route::get('/kelas/join', [SiswaKelasController::class, 'showFormJoin'])->name('kelas.join');
    Route::post('/kelas/join', [SiswaKelasController::class, 'prosesJoin'])->name('kelas.join.proses');
    Route::get('/kelas/{id}', [SiswaKelasController::class, 'show'])->name('kelas.show');
    Route::delete('/kelas/{kelas}/keluar', [SiswaKelasController::class, 'keluar'])->name('kelas.keluar');

    Route::get('/tugas/{id}', [SiswaTugasController::class, 'show'])->name('tugas.show');
    Route::post('/tugas/{id}/kumpulkan', [SiswaTugasController::class, 'kumpulkan'])->name('tugas.kumpulkan');

    Route::get('/tugas/edit/{id}', [SiswaTugasController::class, 'editPengumpulan'])->name('tugas.edit');
    Route::post('/tugas/update/{id}', [SiswaTugasController::class, 'updatePengumpulan'])->name('tugas.update');
    Route::delete('/tugas/batalkan/{id}', [SiswaTugasController::class, 'destroyPengumpulan'])->name('tugas.batalkan');

    // Chat Kelas
Route::get('/chat/kelas/{kelasId}', [ChatController::class, 'kelasIndex'])->name('chat.kelas');
Route::post('/chat/kelas/{kelasId}', [ChatController::class, 'kelasSend'])->name('chat.kelas.send');
Route::get('/chat/kelas/{kelasId}/poll', [ChatController::class, 'pollKelas'])->name('chat.kelas.poll');

// Chat DM
Route::get('/chat/dm/{userId}', [ChatController::class, 'dmIndex'])->name('chat.dm');
Route::post('/chat/dm/{userId}', [ChatController::class, 'dmSend'])->name('chat.dm.send');
Route::get('/chat/dm/{userId}/poll', [ChatController::class, 'pollDm'])->name('chat.dm.poll');

});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
});

