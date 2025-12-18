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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get(
        '/admin/dashboard',
        fn() =>
        view('admin.dashboard')
    )->name('admin.dashboard');
});

// MENTOR
Route::middleware(['auth', 'role:mentor'])->group(function () {
    Route::get(
        '/mentor/dashboard',
        fn() =>
        view('mentor.dashboard')
    )->name('mentor.dashboard');
});

// STUDENT
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get(
        '/student/dashboard',
        fn() =>
        view('student.dashboard')
    )->name('student.dashboard');
});