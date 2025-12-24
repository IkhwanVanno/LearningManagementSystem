@extends('layouts.app')

@section('title', 'Penilaian')

@push('styles')
    @vite('resources/css/student/penilaian.css')
@endpush

@section('content')
    <div class="penilaian-container">
        <div class="page-header">
            <h1>Penilaian</h1>
            <p class="subtitle">Lihat hasil pengerjaan tugas Anda</p>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card card-blue">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <h3>Total Pengerjaan</h3>
                    <p class="stat-number">{{ $stats['total_submissions'] }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>Sudah Dinilai</h3>
                    <p class="stat-number">{{ $stats['graded'] }}</p>
                </div>
            </div>

            <div class="stat-card card-purple">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <h3>Rata-rata Nilai</h3>
                    <p class="stat-number">{{ number_format($stats['average_score'], 1) }}</p>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="stat-icon">⭐</div>
                <div class="stat-content">
                    <h3>Nilai Tertinggi</h3>
                    <p class="stat-number">{{ number_format($stats['highest_score'], 1) }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section card">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label for="class_id">Filter Kelas</label>
                    <select id="class_id" name="class_id" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($myClasses as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="card">
            <div class="card-header">
                <h3>Riwayat Nilai</h3>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari tugas...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tugas</th>
                            <th>Kelas</th>
                            <th>Dikumpulkan</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td><strong>{{ $result->exercise->title }}</strong></td>
                                <td>{{ $result->exercise->classRoom->title }}</td>
                                <td>{{ $result->submitted_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($result->score !== null)
                                        <span class="score-badge {{ $result->score >= 70 ? 'score-good' : 'score-poor' }}">
                                            {{ $result->score }}
                                        </span>
                                    @else
                                        <span class="badge badge-warning">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn-icon btn-info"
                                        onclick="window.location.href='/student/penilaian/{{ $result->id }}/detail'"
                                        title="Lihat Detail">
                                        👁️
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada riwayat pengerjaan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/student/penilaian.js')
@endpush