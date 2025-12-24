@extends('layouts.app')

@section('title', 'Manajemen User')

@push('styles')
    @vite('resources/css/admin/users.css')
@endpush

@section('content')
    <div class="users-container">
        <div class="page-header">
            <h1>Manajemen User</h1>
            <button class="btn btn-primary" id="btnAddUser">
                <span>+</span> Tambah User
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Daftar User</h3>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari user...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role->name }}">
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-edit" data-id="{{ $user->id }}" data-action="edit">
                                            ✏️
                                        </button>

                                        <button class="btn-icon btn-delete" data-id="{{ $user->id }}" data-action="delete">
                                            🗑️
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah User</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="userForm">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required>
                    <span class="error-message" id="error-name"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message" id="error-email"></span>
                </div>

                <div class="form-group">
                    <label for="phone">No. HP <span class="required">*</span></label>
                    <input type="text" id="phone" name="phone" required>
                    <span class="error-message" id="error-phone"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required" id="passwordRequired">*</span></label>
                    <input type="password" id="password" name="password">
                    <small id="passwordHint">Kosongkan jika tidak ingin mengubah password</small>
                    <span class="error-message" id="error-password"></span>
                </div>

                <div class="form-group">
                    <label for="role_id">Role <span class="required">*</span></label>
                    <select id="role_id" name="role_id" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <span class="error-message" id="error-role_id"></span>
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
    @vite('resources/js/admin/users.js')
@endpush