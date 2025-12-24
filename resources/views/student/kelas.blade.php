@extends('layouts.app')

@section('title', 'Kelas')

@push('styles')
    @vite('resources/css/student/kelas.css')
@endpush

@section('content')
    <div class="kelas-container">
        <div class="page-header">
            <h1>Kelas</h1>
            <p class="subtitle">Bergabung dan kelola kelas Anda</p>
        </div>

        <!-- My Classes Section -->
        <div class="section">
            <h2>Kelas Saya</h2>
            <div class="my-classes-grid">
                @forelse($myClasses as $member)
                    <div class="my-class-card">
                        <div class="class-status-indicator status-{{ $member->status->name }}"></div>
                        <div class="class-header">
                            <h3>{{ $member->classRoom->title }}</h3>
                            <span class="badge badge-{{ $member->status->name }}">
                                {{ ucfirst($member->status->name) }}
                            </span>
                        </div>
                        <div class="class-body">
                            <p class="class-desc">{{ Str::limit($member->classRoom->description, 80) }}</p>
                            <p class="class-mentor">👨‍🏫 {{ $member->classRoom->mentor->name }}</p>
                            <p class="class-date">📅 Bergabung: {{ $member->joined_at->format('d M Y') }}</p>
                        </div>
                        <div class="class-footer">
                            @if($member->status->name === 'approved')
                                <button class="btn-sm btn-info"
                                    onclick="window.location.href='/student/kelas/{{ $member->classRoom->id }}/detail'">
                                    Lihat Detail
                                </button>
                            @endif
                            <button class="btn-sm btn-delete btn-leave" data-id="{{ $member->classRoom->id }}">
                                Keluar
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>Anda belum bergabung dengan kelas apapun. Silakan bergabung dengan kelas yang tersedia di bawah.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Available Classes Section -->
        <div class="section">
            <div class="section-header">
                <h2>Kelas Tersedia</h2>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari kelas...">
                </div>
            </div>
            <div class="available-classes-grid">
                @forelse($availableClasses as $class)
                    <div class="available-class-card">
                        <div class="class-header">
                            <h3>{{ $class->title }}</h3>
                            <span class="badge badge-{{ $class->status->name }}">
                                {{ ucfirst($class->status->name) }}
                            </span>
                        </div>
                        <div class="class-body">
                            <p class="class-desc">{{ Str::limit($class->description, 100) }}</p>
                            <div class="class-info">
                                <div class="info-item">
                                    <span class="icon">👨‍🏫</span>
                                    <span>{{ $class->mentor->name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="icon">👥</span>
                                    <span>{{ $class->members_count }} Siswa</span>
                                </div>
                                <div class="info-item">
                                    <span class="icon">📚</span>
                                    <span>{{ $class->materials_count }} Materi</span>
                                </div>
                                <div class="info-item">
                                    <span class="icon">📝</span>
                                    <span>{{ $class->exercises_count }} Tugas</span>
                                </div>
                            </div>
                        </div>
                        <div class="class-footer">
                            <button class="btn-sm btn-primary btn-join" data-id="{{ $class->id }}">
                                Gabung Kelas
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>Tidak ada kelas yang tersedia saat ini</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $availableClasses->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/student/kelas.js')
@endpush