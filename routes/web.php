<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate']);

Route::get('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/register', [AuthController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/users', fn() => view('admin.users'))->name('users');
    Route::get('/kelas', fn() => view('admin.kelas'))->name('kelas');
    Route::get('/master-data', fn() => view('admin.master'))->name('master');
    Route::get('/monitoring', fn() => view('admin.monitoring'))->name('monitoring');
});

// MENTOR
Route::middleware(['auth', 'role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', fn() => view('mentor.dashboard'))->name('dashboard');
    Route::get('/kelas', fn() => view('mentor.kelas'))->name('kelas');
    Route::get('/murid', fn() => view('mentor.murid'))->name('murid');
    Route::get('/materi', fn() => view('mentor.materi'))->name('materi');
    Route::get('/tugas', fn() => view('mentor.tugas'))->name('tugas');
    Route::get('/penilaian', fn() => view('mentor.penilaian'))->name('penilaian');
});

// STUDENT
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', fn() => view('student.dashboard'))->name('dashboard');
    Route::get('/kelas', fn() => view('student.kelas'))->name('kelas');
    Route::get('/materi', fn() => view('student.materi'))->name('materi');
    Route::get('/tugas', fn() => view('student.tugas'))->name('tugas');
    Route::get('/penilaian', fn() => view('student.penilaian'))->name('penilaian');
});
