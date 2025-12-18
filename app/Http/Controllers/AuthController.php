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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()->route('login')->with('success', 'Regrister berhasil');
    }

    // ========== Proses Login ==========
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Login gagal']);
        }

        $user = Auth::user()->load('role');

        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role->name === 'mentor') {
            return redirect()->route('mentor.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    // ========== Proses Logout ==========
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
