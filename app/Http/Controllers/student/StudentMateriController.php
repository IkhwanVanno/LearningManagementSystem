<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\ClassMember;
use Illuminate\Http\Request;

class StudentMateriController extends Controller
{
    public function index(Request $request)
    {
        $studentId = auth()->id();
        $classId = $request->get('class_id');

        // Get student's approved classes
        $approvedClassIds = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->pluck('class_id');

        // Get materials from approved classes
        $query = Material::whereIn('class_id', $approvedClassIds)
            ->with(['classRoom', 'type']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $materials = $query->latest()->paginate(12);

        // Get student's classes for filter
        $myClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->with('classRoom')
            ->get()
            ->pluck('classRoom');

        return view('student.materi', compact('materials', 'myClasses'));
    }

    public function show($id)
    {
        $studentId = auth()->id();

        // Check if student has access
        $material = Material::with(['classRoom', 'type'])->findOrFail($id);

        $hasAccess = ClassMember::where('student_id', $studentId)
            ->where('class_id', $material->class_id)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke materi ini'
            ], 403);
        }

        return response()->json($material);
    }
}