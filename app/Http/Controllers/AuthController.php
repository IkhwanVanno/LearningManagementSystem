<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    // ========== Proses Register ==========
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|min:6',
            'role' => 'required|in:student,mentor'
        ]);

        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return back()->with('error', 'Role tidak valid');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }


    // ========== Proses Login ==========
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Email atau password salah');
        }

        $user = Auth::user()->load('role');

        // (opsional)
        session()->regenerate();

        if ($user->role->name === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Selamat datang Admin');
        }

        if ($user->role->name === 'mentor') {
            return redirect()
                ->route('mentor.dashboard')
                ->with('success', 'Selamat datang Mentor');
        }

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'Selamat datang');
    }

    // ========== Proses Logout ==========
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil logout');

    }
}
