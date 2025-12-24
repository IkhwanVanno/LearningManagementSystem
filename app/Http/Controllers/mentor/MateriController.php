<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $mentorId = auth()->id();
        $classId = $request->get('class_id');

        $query = Material::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->with(['classRoom', 'type']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $materials = $query->latest()->paginate(12);

        $classes = ClassRoom::where('mentor_id', $mentorId)
            ->select('id', 'title')
            ->get();

        $types = MaterialType::all();

        return view('mentor.materi', compact('materials', 'classes', 'types'));
    }

    public function store(Request $request)
    {
        $mentorId = auth()->id();

        // Verify class belongs to mentor
        $class = ClassRoom::where('mentor_id', $mentorId)
            ->where('id', $request->class_id)
            ->firstOrFail();

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'type_id' => 'required|exists:material_types,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        Material::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil ditambahkan'
        ]);
    }

    public function show($id)
    {
        $mentorId = auth()->id();

        $material = Material::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['classRoom', 'type'])
            ->findOrFail($id);

        return response()->json($material);
    }

    public function update(Request $request, $id)
    {
        $mentorId = auth()->id();

        $material = Material::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $validated = $request->validate([
            'type_id' => 'required|exists:material_types,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $material->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $mentorId = auth()->id();

        $material = Material::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dihapus'
        ]);
    }
}