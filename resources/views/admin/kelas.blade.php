@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@push('styles')
    @vite('resources/css/admin/kelas.css')
@endpush

@section('content')
    <div class="kelas-container">
        <div class="page-header">
            <h1>Manajemen Kelas</h1>
            <button class="btn btn-primary" id="btnAddClass">
                <span>+</span> Tambah Kelas
            </button>
        </div>

        <div class="filter-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari kelas...">
            </div>
            <div class="filter-group">
                <select id="statusFilter">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ ucfirst($status->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="classes-grid">
            @forelse($classes as $class)
                <div class="class-card" data-status="{{ $class->status_id }}">
                    <div class="class-header">
                        <h3>{{ $class->title }}</h3>
                        <span class="status-badge status-{{ $class->status->name }}">
                            {{ ucfirst($class->status->name) }}
                        </span>
                    </div>

                    <div class="class-body">
                        <p class="description">{{ Str::limit($class->description, 100) }}</p>

                        <div class="class-info">
                            <div class="info-item">
                                <span class="icon">👨‍🏫</span>
                                <span>{{ $class->mentor->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="icon">👥</span>
                                <span>{{ $class->members_count }} Siswa</span>
                            </div>
                        </div>
                    </div>

                    <div class="class-footer">
                        <button class="btn-sm btn-info btn-detail" data-id="{{ $class->id }}">Detail</button>
                        <button class="btn-sm btn-edit btn-edit-class" data-id="{{ $class->id }}">Edit</button>
                        <button class="btn-sm btn-delete btn-delete-class" data-id="{{ $class->id }}">Hapus</button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada kelas yang dibuat</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $classes->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div id="classModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Kelas</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="classForm">
                @csrf
                <input type="hidden" id="classId" name="class_id">
                <input type="hidden" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="title">Judul Kelas <span class="required">*</span></label>
                    <input type="text" id="title" name="title" required>
                    <span class="error-message" id="error-title"></span>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                    <span class="error-message" id="error-description"></span>
                </div>

                <div class="form-group">
                    <label for="mentor_id">Mentor <span class="required">*</span></label>
                    <select id="mentor_id" name="mentor_id" required>
                        <option value="">Pilih Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                        @endforeach
                    </select>
                    <span class="error-message" id="error-mentor_id"></span>
                </div>

                <div class="form-group">
                    <label for="status_id">Status <span class="required">*</span></label>
                    <select id="status_id" name="status_id" required>
                        <option value="">Pilih Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ ucfirst($status->name) }}</option>
                        @endforeach
                    </select>
                    <span class="error-message" id="error-status_id"></span>
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
    @vite('resources/js/admin/kelas.js')
@endpush