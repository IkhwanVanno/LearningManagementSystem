<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassStatus;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $mentorId = auth()->id();

        $classes = ClassRoom::where('mentor_id', $mentorId)
            ->with(['status', 'members'])
            ->withCount(['members', 'materials', 'exercises'])
            ->paginate(12);

        $statuses = ClassStatus::all();

        return view('mentor.kelas', compact('classes', 'statuses'));
    }

    public function show($id)
    {
        $mentorId = auth()->id();

        $class = ClassRoom::where('mentor_id', $mentorId)
            ->where('id', $id)
            ->with('status')
            ->firstOrFail();

        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $mentorId = auth()->id();

        $class = ClassRoom::where('mentor_id', $mentorId)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
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

    public function detail($id)
    {
        $mentorId = auth()->id();

        $class = ClassRoom::where('mentor_id', $mentorId)
            ->where('id', $id)
            ->with([
                'status',
                'members.student',
                'members.status',
                'materials.type',
                'exercises'
            ])
            ->withCount(['members', 'materials', 'exercises'])
            ->firstOrFail();

        return view('mentor.kelas-detail', compact('class'));
    }
}