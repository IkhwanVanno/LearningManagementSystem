@extends('layouts.app')

@section('title', 'Pemantauan Sistem')

@push('styles')
    @vite('resources/css/admin/monitoring.css')
@endpush

@section('content')
    <div class="monitoring-container">
        <div class="page-header">
            <h1>Pemantauan Sistem</h1>
            <p class="subtitle">Monitor aktivitas dan performa LMS</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section card">
            <form method="GET" action="{{ route('admin.monitoring.index') }}" class="filter-form">
                <div class="form-group">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="form-group">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Activity Summary -->
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon">👤</div>
                <div class="stat-content">
                    <h3>User Baru</h3>
                    <p class="stat-number">{{ $newUsers }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">🏫</div>
                <div class="stat-content">
                    <h3>Kelas Baru</h3>
                    <p class="stat-number">{{ $newClasses }}</p>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3>Anggota Baru</h3>
                    <p class="stat-number">{{ $newMembers }}</p>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>Tugas Selesai</h3>
                    <p class="stat-number">{{ $completedExercises }}</p>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Users -->
            <div class="card">
                <div class="card-header">
                    <h3>User Terbaru</h3>
                </div>
                <div class="activity-list">
                    @forelse($recentUsers as $user)
                        <div class="activity-item">
                            <div class="activity-icon">👤</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $user->name }}</p>
                                <p class="activity-meta">{{ ucfirst($user->role->name) }} •
                                    {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="card">
                <div class="card-header">
                    <h3>Pendaftaran Kelas Terbaru</h3>
                </div>
                <div class="activity-list">
                    @forelse($recentMembers as $member)
                        <div class="activity-item">
                            <div class="activity-icon">📚</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $member->student->name }}</p>
                                <p class="activity-meta">{{ $member->classRoom->title }} •
                                    {{ $member->joined_at->diffForHumans() }}</p>
                            </div>
                            <span class="badge badge-{{ $member->status->name }}">{{ ucfirst($member->status->name) }}</span>
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
                    @forelse($recentExercises as $result)
                        <div class="activity-item">
                            <div class="activity-icon">📝</div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $result->student->name }}</p>
                                <p class="activity-meta">{{ $result->exercise->title }} • Nilai: {{ $result->score }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Class Performance -->
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-header">
                <h3>Performa Kelas</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Anggota</th>
                            <th>Materi</th>
                            <th>Tugas</th>
                            <th>Rata-rata Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classPerformance as $class)
                            <tr>
                                <td><strong>{{ $class['title'] }}</strong></td>
                                <td>{{ $class['members_count'] }} siswa</td>
                                <td>{{ $class['materials_count'] }} materi</td>
                                <td>{{ $class['exercises_count'] }} tugas</td>
                                <td>
                                    <span class="score-badge {{ $class['avg_score'] >= 70 ? 'score-good' : 'score-poor' }}">
                                        {{ $class['avg_score'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $class['status'] }}">
                                        {{ ucfirst($class['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Students -->
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-header">
                <h3>10 Siswa Terbaik</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Nama</th>
                            <th>Rata-rata Nilai</th>
                            <th>Total Tugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topStudents as $index => $student)
                            <tr>
                                <td>
                                    <span class="rank-badge rank-{{ $index + 1 }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td><strong>{{ $student->student->name }}</strong></td>
                                <td>
                                    <span class="score-badge score-good">
                                        {{ round($student->avg_score, 2) }}
                                    </span>
                                </td>
                                <td>{{ $student->total_exercises }} tugas</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Mentors -->
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-header">
                <h3>Mentor Aktif</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Mentor</th>
                            <th>Total Kelas</th>
                            <th>Kelas Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeMentors as $mentor)
                            <tr>
                                <td><strong>{{ $mentor->name }}</strong></td>
                                <td>{{ $mentor->mentor_classes_count }} kelas</td>
                                <td>{{ $mentor->active_classes }} kelas</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/admin/monitoring.js')
@endpush