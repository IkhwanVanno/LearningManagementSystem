<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassMember;
use App\Models\ClassMemberStatus;
use Illuminate\Http\Request;

class StudentKelasController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();

        // Available classes to join
        $availableClasses = ClassRoom::whereHas('status', function ($q) {
            $q->where('name', 'active');
        })
            ->whereDoesntHave('members', function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            })
            ->with(['mentor', 'status'])
            ->withCount(['members', 'materials', 'exercises'])
            ->paginate(12);

        // My classes
        $myClasses = ClassMember::where('student_id', $studentId)
            ->with(['classRoom.mentor', 'classRoom.status', 'status'])
            ->latest('joined_at')
            ->get();

        return view('student.kelas', compact('availableClasses', 'myClasses'));
    }

    public function join(Request $request, $classId)
    {
        $studentId = auth()->id();

        // Check if already joined
        $existing = ClassMember::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar di kelas ini'
            ], 422);
        }

        // Get pending status
        $pendingStatus = ClassMemberStatus::where('name', 'pending')->first();

        ClassMember::create([
            'class_id' => $classId,
            'student_id' => $studentId,
            'status_id' => $pendingStatus->id,
            'joined_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan bergabung berhasil dikirim. Menunggu persetujuan mentor.'
        ]);
    }

    public function leave($classId)
    {
        $studentId = auth()->id();

        $member = ClassMember::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar di kelas ini'
            ], 404);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil keluar dari kelas'
        ]);
    }

    public function detail($id)
    {
        $studentId = auth()->id();

        // Check if student is member
        $member = ClassMember::where('student_id', $studentId)
            ->where('class_id', $id)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->first();

        if (!$member) {
            return redirect()->route('student.kelas.index')
                ->with('error', 'Anda tidak memiliki akses ke kelas ini');
        }

        $class = ClassRoom::with([
            'mentor',
            'status',
            'materials.type',
            'exercises'
        ])
            ->withCount(['members', 'materials', 'exercises'])
            ->findOrFail($id);

        return view('student.kelas-detail', compact('class'));
    }
}