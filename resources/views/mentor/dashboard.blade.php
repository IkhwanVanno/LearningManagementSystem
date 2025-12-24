@extends('layouts.app')

@section('title', 'Dashboard Mentor')

@push('styles')
    @vite('resources/css/mentor/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="page-header">
            <h1>Dashboard Mentor</h1>
            <p class="subtitle">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon">🏫</div>
                <div class="stat-content">
                    <h3>Total Kelas</h3>
                    <p class="stat-number">{{ $totalClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>Kelas Aktif</h3>
                    <p class="stat-number">{{ $activeClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3>Total Siswa</h3>
                    <p class="stat-number">{{ $totalStudents }}</p>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <h3>Total Materi</h3>
                    <p class="stat-number">{{ $totalMaterials }}</p>
                </div>
            </div>

            <div class="stat-card card-cyan">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <h3>Total Tugas</h3>
                    <p class="stat-number">{{ $totalExercises }}</p>
                </div>
            </div>

            <div class="stat-card card-pink">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <h3>Perlu Dinilai</h3>
                    <p class="stat-number">{{ $pendingSubmissions }}</p>
                </div>
            </div>
        </div>

        <!-- My Classes -->
        <div class="card">
            <div class="card-header">
                <h3>Kelas Saya</h3>
                <a href="{{ route('mentor.kelas.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="classes-grid">
                @forelse($myClasses as $class)
                    <div class="class-mini-card">
                        <div class="class-mini-header">
                            <h4>{{ $class->title }}</h4>
                            <span class="badge badge-{{ $class->status->name }}">
                                {{ ucfirst($class->status->name) }}
                            </span>
                        </div>
                        <div class="class-mini-stats">
                            <span>👥 {{ $class->members_count }} Siswa</span>
                            <span>📚 {{ $class->materials_count }} Materi</span>
                            <span>📝 {{ $class->exercises_count }} Tugas</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada kelas</p>
                @endforelse
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Members -->
            <div class="card">
                <div class="card-header">
                    <h3>Siswa Baru</h3>
                </div>
                <div class="activity-list">
                    @forelse($recentMembers as $member)
                        <div class="activity-item">
                            <div class="activity-icon">👤</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $member->student->name }}</p>
                                <p class="activity-meta">{{ $member->classRoom->title }} •
                                    {{ $member->joined_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="badge badge-{{ $member->status->name }}">
                                {{ ucfirst($member->status->name) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="card">
                <div class="card-header">
                    <h3>Pengerjaan Tugas Terbaru</h3>
                </div>
                <div class="activity-list">
                    @forelse($recentSubmissions as $result)
                        <div class="activity-item">
                            <div class="activity-icon">📝</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $result->student->name }}</p>
                                <p class="activity-meta">
                                    {{ $result->exercise->title }} •
                                    @if($result->score)
                                        Nilai: {{ $result->score }}
                                    @else
                                        <span class="text-warning">Belum dinilai</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Class Performance Chart -->
        <div class="card">
            <div class="card-header">
                <h3>Performa Kelas</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/dashboard.js')
@endpush