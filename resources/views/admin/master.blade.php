@extends('layouts.app')

@section('title', 'Master Data')

@push('styles')
    @vite('resources/css/admin/master.css')
@endpush

@section('content')
    <div class="master-container">
        <div class="page-header">
            <h1>Master Data</h1>
            <p class="subtitle">Kelola data referensi sistem</p>
        </div>

        <div class="tabs">
            <button class="tab-btn active" data-tab="class-status">Status Kelas</button>
            <button class="tab-btn" data-tab="member-status">Status Anggota</button>
            <button class="tab-btn" data-tab="material-type">Tipe Materi</button>
            <button class="tab-btn" data-tab="role">Role</button>
        </div>


        <!-- Class Status Tab -->
        <div id="class-status-tab" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <h3>Status Kelas</h3>
                    <button class="btn btn-primary btn-sm btn-add" data-type="class-status" data-mode="add">
                        + Tambah Status
                    </button>

                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Status</th>
                                <th>Jumlah Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classStatuses as $index => $status)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ ucfirst($status->name) }}</strong></td>
                                    <td>{{ $status->classes()->count() }} kelas</td>
                                    <td>
                                        <button class="btn-icon btn-edit" data-action="edit" data-type="class-status"
                                            data-id="{{ $status->id }}" data-name="{{ $status->name }}">✏️</button>

                                        <button class="btn-icon btn-delete" data-action="delete" data-type="class-status"
                                            data-id="{{ $status->id }}">🗑️</button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Member Status Tab -->
        <div id="member-status-tab" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h3>Status Anggota Kelas</h3>
                    <button class="btn btn-primary btn-sm" onclick="openModal('member-status', 'add')">
                        + Tambah Status
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Status</th>
                                <th>Jumlah Anggota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($memberStatuses as $index => $status)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ ucfirst($status->name) }}</strong></td>
                                    <td>{{ $status->classMembers()->count() }} anggota</td>
                                    <td>
                                        <button class="btn-icon btn-edit"
                                            onclick="editItem('member-status', {{ $status->id }}, '{{ $status->name }}')">✏️</button>
                                        <button class="btn-icon btn-delete"
                                            onclick="deleteItem('member-status', {{ $status->id }})">🗑️</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Material Type Tab -->
        <div id="material-type-tab" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h3>Tipe Materi</h3>
                    <button class="btn btn-primary btn-sm" onclick="openModal('material-type', 'add')">
                        + Tambah Tipe
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tipe</th>
                                <th>Jumlah Materi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materialTypes as $index => $type)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ ucfirst($type->name) }}</strong></td>
                                    <td>{{ $type->materials()->count() }} materi</td>
                                    <td>
                                        <button class="btn-icon btn-edit"
                                            onclick="editItem('material-type', {{ $type->id }}, '{{ $type->name }}')">✏️</button>
                                        <button class="btn-icon btn-delete"
                                            onclick="deleteItem('material-type', {{ $type->id }})">🗑️</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Role Tab -->
        <div id="role-tab" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h3>Role Pengguna</h3>
                    <button class="btn btn-primary btn-sm" onclick="openModal('role', 'add')">
                        + Tambah Role
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Role</th>
                                <th>Jumlah User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ ucfirst($role->name) }}</strong></td>
                                    <td>{{ $role->users()->count() }} user</td>
                                    <td>
                                        <button class="btn-icon btn-edit"
                                            onclick="editItem('role', {{ $role->id }}, '{{ $role->name }}')">✏️</button>
                                        <button class="btn-icon btn-delete"
                                            onclick="deleteItem('role', {{ $role->id }})">🗑️</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Universal Modal -->
    <div id="masterModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Data</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="masterForm">
                @csrf
                <input type="hidden" id="itemId">
                <input type="hidden" id="itemType">
                <input type="hidden" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="name">Nama <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required>
                    <span class="error-message" id="error-name"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelModal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/js/admin/master.js')
@endpush