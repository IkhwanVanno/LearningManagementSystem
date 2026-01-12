@extends('layouts.app')

@section('title', 'Manajemen Tugas')

@push('styles')
    @vite('resources/css/mentor/tugas.css')
@endpush

@section('content')
    <div class="tugas-container">
        <div class="page-header">
            <h1>Manajemen Tugas / Quiz</h1>
            <button class="btn btn-primary" id="btnAddTugas">
                <span>+</span> Tambah Tugas
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari tugas...">
            </div>
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <select id="class_id" name="class_id" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Exercises Grid -->
        <div class="exercises-grid">
            @forelse($exercises as $exercise)
                <div class="exercise-card">
                    <div class="exercise-header">
                        <h3>{{ $exercise->title }}</h3>
                        <div class="question-count">
                            {{ $exercise->questions_count }} Soal
                        </div>
                    </div>

                    <div class="exercise-body">
                        <p class="exercise-class">📚 {{ $exercise->classRoom->title }}</p>
                        <p class="exercise-desc">{{ Str::limit($exercise->description, 100) }}</p>
                    </div>

                    <div class="exercise-footer">
                        <button class="btn-sm btn-success btn-manage" data-id="{{ $exercise->id }}">
                            Kelola Soal
                        </button>
                        <button class="btn-sm btn-edit btn-edit-tugas" data-id="{{ $exercise->id }}">
                            Edit
                        </button>
                        <button class="btn-sm btn-delete btn-delete-tugas" data-id="{{ $exercise->id }}">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada tugas yang dibuat</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $exercises->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Modal Add/Edit Exercise -->
    <div id="tugasModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Tugas</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="tugasForm">
                @csrf
                <input type="hidden" id="tugasId" name="tugas_id">
                <input type="hidden" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="class_id_form">Kelas <span class="required">*</span></label>
                    <select id="class_id_form" name="class_id" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                        @endforeach
                    </select>
                    <span class="error-message" id="error-class_id"></span>
                </div>

                <div class="form-group">
                    <label for="title">Judul Tugas <span class="required">*</span></label>
                    <input type="text" id="title" name="title" required>
                    <span class="error-message" id="error-title"></span>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                    <span class="error-message" id="error-description"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelModal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/tugas.js')
@endpush