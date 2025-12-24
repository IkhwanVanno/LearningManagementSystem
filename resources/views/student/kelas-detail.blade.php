@extends('layouts.app')

@section('title', 'Detail Kelas')

@push('styles')
    @vite('resources/css/student/kelas-detail.css')
@endpush

@section('content')
    <div class="kelas-detail-container">
        <div class="page-header">
            <div>
                <h1>{{ $class->title }}</h1>
                <p class="subtitle">{{ $class->mentor->name }}</p>
            </div>
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('student.kelas.index') }}'">
                ← Kembali
            </button>
        </div>

        <!-- Class Info Cards -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon">👥</div>
                <div class="info-content">
                    <h3>Total Siswa</h3>
                    <p class="info-number">{{ $class->members_count }}</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">📚</div>
                <div class="info-content">
                    <h3>Total Materi</h3>
                    <p class="info-number">{{ $class->materials_count }}</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">📝</div>
                <div class="info-content">
                    <h3>Total Tugas</h3>
                    <p class="info-number">{{ $class->exercises_count }}</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">📊</div>
                <div class="info-content">
                    <h3>Status</h3>
                    <p class="info-badge badge-{{ $class->status->name }}">
                        {{ ucfirst($class->status->name) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Class Description -->
        <div class="card">
            <div class="card-header">
                <h3>Deskripsi Kelas</h3>
            </div>
            <div class="card-body">
                <p>{{ $class->description }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <div class="tabs">
                <button class="tab-btn active" data-tab="materials">
                    Materi ({{ $class->materials_count }})
                </button>
                <button class="tab-btn" data-tab="exercises">
                    Tugas ({{ $class->exercises_count }})
                </button>
            </div>

            <!-- Tab Content: Materials -->
            <div class="tab-content active" id="materials-tab">
                <div class="card">
                    <div class="card-header">
                        <h3>Daftar Materi</h3>
                    </div>
                    <div class="materials-list">
                        @forelse($class->materials as $material)
                            <div class="material-item">
                                <div class="material-icon">
                                    @if($material->type->name == 'video')
                                        🎥
                                    @elseif($material->type->name == 'document')
                                        📄
                                    @elseif($material->type->name == 'slide')
                                        📊
                                    @else
                                        📝
                                    @endif
                                </div>
                                <div class="material-info">
                                    <h4>{{ $material->title }}</h4>
                                    <p class="material-meta">
                                        <span class="type-badge type-{{ $material->type->name }}">
                                            {{ ucfirst($material->type->name) }}
                                        </span>
                                        <span>{{ $material->created_at->format('d M Y') }}</span>
                                    </p>
                                </div>
                                <button class="btn-sm btn-info btn-view-material" data-id="{{ $material->id }}">
                                    Lihat
                                </button>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>Belum ada materi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Tab Content: Exercises -->
            <div class="tab-content" id="exercises-tab">
                <div class="card">
                    <div class="card-header">
                        <h3>Daftar Tugas</h3>
                    </div>
                    <div class="exercises-list">
                        @forelse($class->exercises as $exercise)
                            <div class="exercise-item">
                                <div class="exercise-icon">📝</div>
                                <div class="exercise-info">
                                    <h4>{{ $exercise->title }}</h4>
                                    <p>{{ Str::limit($exercise->description, 100) }}</p>
                                </div>
                                <button class="btn-sm btn-primary"
                                    onclick="window.location.href='/student/tugas/{{ $exercise->id }}'">
                                    Kerjakan
                                </button>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>Belum ada tugas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Material -->
    <div id="materialModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="materialTitle">Detail Materi</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="view-content">
                    <div class="view-meta">
                        <span id="materialType"></span>
                    </div>
                    <div id="materialContent"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/student/kelas-detail.js')
@endpush