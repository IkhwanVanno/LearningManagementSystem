@extends('layouts.app')

@section('content')
<div class="profile-container">

    {{-- PROFILE HEADER --}}
    <div class="profile-header">
        <img src="{{ asset('images/profile.png') }}" class="profile-avatar">

        <h3 class="profile-role">
            saya adalah seorang {{ strtolower(auth()->user()->role->name) }}
        </h3>
    </div>
    
    {{-- PROFILE FORM --}}
    <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="divider"></div>

        <div class="form-group">
            <label>Password Baru (opsional)</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit" class="btn-primary">
            Simpan Perubahan
        </button>
    </form>

</div>
@endsection
