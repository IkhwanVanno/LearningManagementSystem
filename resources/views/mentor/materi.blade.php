@extends('layouts.app')

@section('title', 'Manajemen Materi')

@push('styles')
    @vite('resources/css/mentor/materi.css')
@endpush

@section('content')
    <div class="materi-container">
        <div class="page-header">
            <h1>Manajemen Materi</h1>
            <button class="btn btn-primary" id="btnAddMateri">
                <span>+</span> Tambah Materi
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari materi...">
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

        <!-- Materials Grid -->
        <div class="materials-grid">
            @forelse($materials as $material)
                <div class="material-card">
                    <div class="material-header">
                        <div class="type-badge type-{{ $material->type->name }}">
                            {{ ucfirst($material->type->name) }}
                        </div>
                        <div class="material-actions">
                            <button class="btn-icon btn-edit" data-id="{{ $material->id }}">✏️</button>
                            <button class="btn-icon btn-delete" data-id="{{ $material->id }}">🗑️</button>
                        </div>
                    </div>

                    <div class="material-body">
                        <h3>{{ $material->title }}</h3>
                        <p class="material-class">📚 {{ $material->classRoom->title }}</p>
                        <p class="material-preview">{{ Str::limit(strip_tags($material->content), 100) }}</p>
                    </div>

                    <div class="material-footer">
                        <span class="material-date">{{ $material->created_at->format('d M Y') }}</span>
                        <button class="btn-sm btn-info btn-view" data-id="{{ $material->id }}">Lihat Detail</button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada materi yang dibuat</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $materials->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="materiModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Materi</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="materiForm">
                @csrf
                <input type="hidden" id="materiId" name="material_id">
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
                    <label for="type_id">Tipe Materi <span class="required">*</span></label>
                    <select id="type_id" name="type_id" required>
                        <option value="">Pilih Tipe</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                        @endforeach
                    </select>
                    <span class="error-message" id="error-type_id"></span>
                </div>

                <div class="form-group">
                    <label for="title">Judul Materi <span class="required">*</span></label>
                    <input type="text" id="title" name="title" required>
                    <span class="error-message" id="error-title"></span>
                </div>

                <div class="form-group">
                    <label for="content">Konten Materi <span class="required">*</span></label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                    <span class="error-message" id="error-content"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelModal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal View -->
    <div id="viewModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="viewTitle">Detail Materi</h2>
                <span class="close" id="btnCloseView">&times;</span>
            </div>
            <div class="modal-body">
                <div class="view-content">
                    <div class="view-meta">
                        <span id="viewClass"></span>
                        <span id="viewType"></span>
                    </div>
                    <div id="viewContent"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/materi.js')
@endpush