@extends('layouts.app')

@section('title', 'Dashboard Student')

@push('styles')
    @vite('resources/css/student/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="page-header">
            <h1>Dashboard Student</h1>
            <p class="subtitle">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon">🏫</div>
                <div class="stat-content">
                    <h3>Kelas Aktif</h3>
                    <p class="stat-number">{{ $totalClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <h3>Menunggu Persetujuan</h3>
                    <p class="stat-number">{{ $pendingClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <h3>Tugas Dikerjakan</h3>
                    <p class="stat-number">{{ $totalSubmissions }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <h3>Rata-rata Nilai</h3>
                    <p class="stat-number">{{ number_format($averageScore, 1) }}</p>
                </div>
            </div>
        </div>

        <!-- My Classes -->
        <div class="card">
            <div class="card-header">
                <h3>Kelas Saya</h3>
                <a href="{{ route('student.kelas.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="classes-grid">
                @forelse($myClasses as $member)
                    <div class="class-mini-card">
                        <div class="class-mini-header">
                            <h4>{{ $member->classRoom->title }}</h4>
                            <span class="badge badge-{{ $member->classRoom->status->name }}">
                                {{ ucfirst($member->classRoom->status->name) }}
                            </span>
                        </div>
                        <div class="class-mini-body">
                            <p>👨‍🏫 {{ $member->classRoom->mentor->name }}</p>
                        </div>
                        <button class="btn-sm btn-info"
                            onclick="window.location.href='/student/kelas/{{ $member->classRoom->id }}/detail'">
                            Lihat Detail
                        </button>
                    </div>
                @empty
                    <p class="text-center">Anda belum bergabung dengan kelas apapun</p>
                @endforelse
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Pending Exercises -->
            <div class="card">
                <div class="card-header">
                    <h3>Tugas Belum Dikerjakan</h3>
                </div>
                <div class="activity-list">
                    @forelse($pendingExercises as $exercise)
                        <div class="activity-item">
                            <div class="activity-icon">📝</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $exercise->title }}</p>
                                <p class="activity-meta">{{ $exercise->class_title }}</p>
                            </div>
                            <button class="btn-sm btn-primary"
                                onclick="window.location.href='/student/tugas/{{ $exercise->id }}'">
                                Kerjakan
                            </button>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada tugas pending</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card">
                <div class="card-header">
                    <h3>Aktivitas Terbaru</h3>
                </div>
                <div class="activity-list">
                    @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">✅</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $activity->exercise->title }}</p>
                                <p class="activity-meta">
                                    {{ $activity->exercise->classRoom->title }} •
                                    @if($activity->score !== null)
                                        Nilai: {{ $activity->score }}
                                    @else
                                        Belum dinilai
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/student/dashboard.js')
@endpush