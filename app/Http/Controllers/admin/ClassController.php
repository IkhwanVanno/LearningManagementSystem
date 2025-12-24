<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\ClassStatus;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with(['mentor', 'status', 'members'])
            ->withCount('members')
            ->paginate(10);

        $mentors = User::whereHas('role', function ($q) {
            $q->where('name', 'mentor');
        })->get();

        $statuses = ClassStatus::all();

        return view('admin.kelas', compact('classes', 'mentors', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:class_statuses,id'
        ]);

        ClassRoom::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan'
        ]);
    }

    public function show($id)
    {
        $class = ClassRoom::with(['mentor', 'status'])->findOrFail($id);
        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);

        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:class_statuses,id'
        ]);

        $class->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $class = ClassRoom::findOrFail($id);

        // Check if class has members
        if ($class->members()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus kelas yang memiliki anggota'
            ], 422);
        }

        $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }

    public function detail($id)
    {
        $class = ClassRoom::with([
            'mentor',
            'status',
            'members.student',
            'members.status',
            'materials.type',
            'exercises'
        ])->withCount(['members', 'materials', 'exercises'])
            ->findOrFail($id);

        return view('admin.kelas-detail', compact('class'));
    }
}