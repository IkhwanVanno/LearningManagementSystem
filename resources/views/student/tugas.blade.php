@extends('layouts.app')

@section('title', 'Tugas / Quiz')

@push('styles')
    @vite('resources/css/student/tugas.css')
@endpush

@section('content')
    <div class="tugas-container">
        <div class="page-header">
            <h1>Tugas / Quiz</h1>
            <p class="subtitle">Kerjakan tugas dari kelas Anda</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="form-group">
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
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari tugas...">
            </div>
        </div>

        <!-- Exercises Grid -->
        <div class="exercises-grid">
            @forelse($exercises as $exercise)
                <div class="exercise-card {{ $exercise->result ? 'completed' : '' }}">
                    <div class="exercise-header">
                        <h3>{{ $exercise->title }}</h3>
                        <div class="exercise-meta">
                            <span class="question-count">{{ $exercise->questions_count }} Soal</span>
                            @if($exercise->result)
                                <span class="badge badge-success">Sudah Dikerjakan</span>
                            @else
                                <span class="badge badge-warning">Belum Dikerjakan</span>
                            @endif
                        </div>
                    </div>

                    <div class="exercise-body">
                        <p class="exercise-class">📚 {{ $exercise->classRoom->title }}</p>
                        <p class="exercise-desc">{{ Str::limit($exercise->description, 100) }}</p>

                        @if($exercise->result)
                            <div class="result-info">
                                <div class="result-item">
                                    <span class="result-label">Nilai:</span>
                                    <span class="result-value score-{{ $exercise->result->score >= 70 ? 'good' : 'poor' }}">
                                        {{ $exercise->result->score }}
                                    </span>
                                </div>
                                <div class="result-item">
                                    <span class="result-label">Dikumpulkan:</span>
                                    <span class="result-value">{{ $exercise->result->submitted_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="exercise-footer">
                        @if($exercise->result)
                            <button class="btn-sm btn-secondary" disabled>
                                Sudah Dikerjakan
                            </button>
                        @else
                            <button class="btn-sm btn-primary" onclick="window.location.href='/student/tugas/{{ $exercise->id }}'">
                                Mulai Kerjakan
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada tugas tersedia</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $exercises->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/student/tugas.js')
@endpush