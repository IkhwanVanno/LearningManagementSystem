<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\mentor\MateriController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\mentor\MentorKelasController;
use App\Http\Controllers\Mentor\MuridController;
use App\Http\Controllers\mentor\PenilaianController;
use App\Http\Controllers\mentor\TugasController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentKelasController;
use App\Http\Controllers\Student\StudentMateriController;
use App\Http\Controllers\Student\StudentPenilaianController;
use App\Http\Controllers\Student\StudentTugasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate']);

Route::get('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/register', [AuthController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Class Management
        Route::get('/kelas', [ClassController::class, 'index'])->name('kelas.index');
        Route::post('/kelas', [ClassController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{id}', [ClassController::class, 'show'])->name('kelas.show');
        Route::get('/kelas/{id}/detail', [ClassController::class, 'detail'])->name('kelas.detail');
        Route::put('/kelas/{id}', [ClassController::class, 'update'])->name('kelas.update');
        Route::delete('/kelas/{id}', [ClassController::class, 'destroy'])->name('kelas.destroy');

        // Master Data Management
        Route::get('/master-data', [MasterDataController::class, 'index'])->name('master.index');
        Route::post('/master-data/class-status', [MasterDataController::class, 'storeClassStatus'])->name('master.class-status.store');
        Route::put('/master-data/class-status/{id}', [MasterDataController::class, 'updateClassStatus'])->name('master.class-status.update');
        Route::delete('/master-data/class-status/{id}', [MasterDataController::class, 'destroyClassStatus'])->name('master.class-status.destroy');
        Route::post('/master-data/member-status', [MasterDataController::class, 'storeMemberStatus'])->name('master.member-status.store');
        Route::put('/master-data/member-status/{id}', [MasterDataController::class, 'updateMemberStatus'])->name('master.member-status.update');
        Route::delete('/master-data/member-status/{id}', [MasterDataController::class, 'destroyMemberStatus'])->name('master.member-status.destroy');
        Route::post('/master-data/material-type', [MasterDataController::class, 'storeMaterialType'])->name('master.material-type.store');
        Route::put('/master-data/material-type/{id}', [MasterDataController::class, 'updateMaterialType'])->name('master.material-type.update');
        Route::delete('/master-data/material-type/{id}', [MasterDataController::class, 'destroyMaterialType'])->name('master.material-type.destroy');
        Route::post('/master-data/role', [MasterDataController::class, 'storeRole'])->name('master.role.store');
        Route::put('/master-data/role/{id}', [MasterDataController::class, 'updateRole'])->name('master.role.update');
        Route::delete('/master-data/role/{id}', [MasterDataController::class, 'destroyRole'])->name('master.role.destroy');

        // Monitoring
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    });

// MENTOR ROUTES
Route::middleware(['auth', 'role:mentor'])
    ->prefix('mentor')
    ->name('mentor.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');

        // Kelas Management
        Route::get('/kelas', [MentorKelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/{id}', [MentorKelasController::class, 'show'])->name('kelas.show');
        Route::get('/kelas/{id}/detail', [MentorKelasController::class, 'detail'])->name('kelas.detail');
        Route::put('/kelas/{id}', [MentorKelasController::class, 'update'])->name('kelas.update');

        // Murid Management
        Route::get('/murid', [MuridController::class, 'index'])->name('murid.index');
        Route::put('/murid/{id}/status', [MuridController::class, 'updateStatus'])->name('murid.update-status');
        Route::delete('/murid/{id}', [MuridController::class, 'destroy'])->name('murid.destroy');
        Route::post('/murid/bulk-approve', [MuridController::class, 'bulkApprove'])->name('murid.bulk-approve');
        Route::post('/murid/bulk-reject', [MuridController::class, 'bulkReject'])->name('murid.bulk-reject');

        // Materi Management
        Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
        Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
        Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');
        Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
        Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');

        // Tugas Management
        Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
        Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
        Route::get('/tugas/{id}', [TugasController::class, 'show'])->name('tugas.show');
        Route::get('/tugas/{id}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
        Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
        Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');

        // Question Management (untuk tugas)
        Route::post('/tugas/{id}/questions', [TugasController::class, 'storeQuestion'])->name('tugas.store-question');
        Route::put('/tugas/questions/{questionId}', [TugasController::class, 'updateQuestion'])->name('tugas.update-question');
        Route::delete('/tugas/questions/{questionId}', [TugasController::class, 'destroyQuestion'])->name('tugas.destroy-question');

        // Penilaian
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/exercise/{id}', [PenilaianController::class, 'showExerciseResults'])->name('penilaian.exercise');
        Route::put('/penilaian/result/{id}', [PenilaianController::class, 'updateScore'])->name('penilaian.update-score');
    });

// STUDENT ROUTES
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Kelas Management
        Route::get('/kelas', [StudentKelasController::class, 'index'])->name('kelas.index');
        Route::post('/kelas/{id}/join', [StudentKelasController::class, 'join'])->name('kelas.join');
        Route::delete('/kelas/{id}/leave', [StudentKelasController::class, 'leave'])->name('kelas.leave');
        Route::get('/kelas/{id}/detail', [StudentKelasController::class, 'detail'])->name('kelas.detail');

        // Materi
        Route::get('/materi', [StudentMateriController::class, 'index'])->name('materi.index');
        Route::get('/materi/{id}', [StudentMateriController::class, 'show'])->name('materi.show');

        // Tugas
        Route::get('/tugas', [StudentTugasController::class, 'index'])->name('tugas.index');
        Route::get('/tugas/{id}', [StudentTugasController::class, 'show'])->name('tugas.show');
        Route::post('/tugas/{id}/submit', [StudentTugasController::class, 'submit'])->name('tugas.submit');

        // Penilaian
        Route::get('/penilaian', [StudentPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{id}/detail', [StudentPenilaianController::class, 'detail'])->name('penilaian.detail');
    });