@extends('layouts.app')

@section('title', 'Penilaian')

@push('styles')
    @vite('resources/css/mentor/penilaian.css')
@endpush

@section('content')
    <div class="penilaian-container">
        <div class="page-header">
            <h1>Penilaian</h1>
            <p class="subtitle">Kelola dan nilai hasil tugas siswa</p>
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

            <div class="stat-card card-orange">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <h3>Perlu Dinilai</h3>
                    <p class="stat-number">{{ $stats['pending_reviews'] }}</p>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <h3>Rata-rata Nilai</h3>
                    <p class="stat-number">{{ number_format($stats['average_score'], 1) }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section card">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label for="class_id">Kelas</label>
                    <select id="class_id" name="class_id" onchange="loadExercises(this.value)">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exercise_id">Tugas</label>
                    <select id="exercise_id" name="exercise_id">
                        <option value="">Semua Tugas</option>
                        @foreach($exercises as $exercise)
                            <option value="{{ $exercise->id }}" {{ $exerciseId == $exercise->id ? 'selected' : '' }}>
                                {{ $exercise->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Results Table -->
        <div class="card">
            <div class="card-header">
                <h3>Hasil Pengerjaan Tugas</h3>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari siswa...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
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
                                <td><strong>{{ $result->student->name }}</strong></td>
                                <td>{{ $result->exercise->title }}</td>
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
                                    <button class="btn-icon btn-edit btn-grade" data-id="{{ $result->id }}"
                                        data-student="{{ $result->student->name }}"
                                        data-exercise="{{ $result->exercise->title }}" data-score="{{ $result->score }}"
                                        title="Beri Nilai">
                                        📝
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada hasil pengerjaan</td>
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

    <!-- Modal Grade -->
    <div id="gradeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Beri Nilai</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="gradeForm">
                @csrf
                <input type="hidden" id="resultId" name="result_id">

                <div class="grade-info">
                    <p><strong>Siswa:</strong> <span id="studentName"></span></p>
                    <p><strong>Tugas:</strong> <span id="exerciseName"></span></p>
                </div>

                <div class="form-group">
                    <label for="score">Nilai (0-100) <span class="required">*</span></label>
                    <input type="number" id="score" name="score" min="0" max="100" step="0.1" required>
                    <span class="error-message" id="error-score"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelModal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/penilaian.js')
@endpush