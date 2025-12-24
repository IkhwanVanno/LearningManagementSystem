@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

@push('styles')
    @vite('resources/css/student/materi.css')
@endpush

@section('content')
    <div class="materi-container">
        <div class="page-header">
            <h1>Materi Pembelajaran</h1>
            <p class="subtitle">Akses materi dari kelas Anda</p>
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
                <input type="text" id="searchInput" placeholder="Cari materi...">
            </div>
        </div>

        <!-- Materials Grid -->
        <div class="materials-grid">
            @forelse($materials as $material)
                <div class="material-card">
                    <div class="material-header">
                        <div class="type-badge type-{{ $material->type->name }}">
                            {{ ucfirst($material->type->name) }}
                        </div>
                    </div>

                    <div class="material-body">
                        <div class="material-icon-large">
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
                        <h3>{{ $material->title }}</h3>
                        <p class="material-class">📚 {{ $material->classRoom->title }}</p>
                        <p class="material-date">{{ $material->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="material-footer">
                        <button class="btn-sm btn-primary btn-view" data-id="{{ $material->id }}">
                            Lihat Materi
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada materi tersedia</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $materials->appends(request()->query())->links() }}
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
    @vite('resources/js/student/materi.js')
@endpush