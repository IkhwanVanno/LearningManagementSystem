@extends('layouts.app')

@section('title', 'Manajemen Murid')

@push('styles')
    @vite('resources/css/mentor/murid.css')
@endpush

@section('content')
    <div class="murid-container">
        <div class="page-header">
            <h1>Manajemen Murid</h1>
            <div class="header-actions">
                <button class="btn btn-success btn-sm" id="btnBulkApprove" style="display:none;">
                    ✓ Setujui Terpilih
                </button>
                <button class="btn btn-danger btn-sm" id="btnBulkReject" style="display:none;">
                    ✗ Tolak Terpilih
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section card">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label for="class_id">Kelas</label>
                    <select id="class_id" name="class_id">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_id">Status</label>
                    <select id="status_id" name="status_id">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Members Table -->
        <div class="card">
            <div class="card-header">
                <h3>Daftar Murid</h3>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari murid...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>
                                    <input type="checkbox" class="member-checkbox" value="{{ $member->id }}">
                                </td>
                                <td><strong>{{ $member->student->name }}</strong></td>
                                <td>{{ $member->student->email }}</td>
                                <td>{{ $member->classRoom->title }}</td>
                                <td>{{ $member->joined_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $member->status->name }}">
                                        {{ ucfirst($member->status->name) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($member->status->name === 'pending')
                                            <button class="btn-icon btn-success btn-approve" data-id="{{ $member->id }}"
                                                title="Setujui">
                                                ✓
                                            </button>
                                            <button class="btn-icon btn-danger btn-reject" data-id="{{ $member->id }}"
                                                title="Tolak">
                                                ✗
                                            </button>
                                        @endif
                                        <button class="btn-icon btn-delete btn-remove" data-id="{{ $member->id }}"
                                            title="Keluarkan">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada murid</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $members->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/murid.js')
@endpush