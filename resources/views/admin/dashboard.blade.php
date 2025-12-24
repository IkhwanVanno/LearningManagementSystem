@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    @vite('resources/css/admin/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="page-header">
            <h1>Dashboard Admin</h1>
            <p class="subtitle">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3>Total User</h3>
                    <p class="stat-number">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">👨‍🎓</div>
                <div class="stat-content">
                    <h3>Total Student</h3>
                    <p class="stat-number">{{ $totalStudents }}</p>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-icon">👨‍🏫</div>
                <div class="stat-content">
                    <h3>Total Mentor</h3>
                    <p class="stat-number">{{ $totalMentors }}</p>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="stat-icon">🏫</div>
                <div class="stat-content">
                    <h3>Total Kelas</h3>
                    <p class="stat-number">{{ $totalClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-cyan">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>Kelas Aktif</h3>
                    <p class="stat-number">{{ $activeClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-pink">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <h3>Total Tugas</h3>
                    <p class="stat-number">{{ $totalExercises }}</p>
                </div>
            </div>
        </div>

        <!-- Charts and Tables Row -->
        <div class="content-grid">
            <!-- Recent Users -->
            <div class="card">
                <div class="card-header">
                    <h3>User Terbaru</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="simple-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $user->role->name }}">
                                                {{ ucfirst($user->role->name) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Class Status Distribution -->
            <div class="card">
                <div class="card-header">
                    <h3>Status Kelas</h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        @forelse($classStats as $stat)
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>{{ $stat->status->name ?? 'Unknown' }}</span>
                                    <span class="progress-value">{{ $stat->total }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ ($stat->total / $totalClasses) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Belum ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Registration Chart -->
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-header">
                <h3>Registrasi User (6 Bulan Terakhir)</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Classes by Members -->
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-header">
                <h3>Kelas dengan Anggota Terbanyak</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Jumlah Anggota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($memberDistribution as $item)
                                <tr>
                                    <td>{{ $item->classRoom->title ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->total }} siswa</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/js/admin/dashboard.js')
@endpush