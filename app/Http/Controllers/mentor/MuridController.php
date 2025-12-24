<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassMember;
use App\Models\ClassMemberStatus;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index(Request $request)
    {
        $mentorId = auth()->id();
        $classId = $request->get('class_id');
        $statusId = $request->get('status_id');

        $query = ClassMember::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->with(['student', 'classRoom', 'status']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($statusId) {
            $query->where('status_id', $statusId);
        }

        $members = $query->latest('joined_at')->paginate(15);

        $classes = ClassRoom::where('mentor_id', $mentorId)
            ->select('id', 'title')
            ->get();

        $statuses = ClassMemberStatus::all();

        return view('mentor.murid', compact('members', 'classes', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $mentorId = auth()->id();

        $member = ClassMember::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $validated = $request->validate([
            'status_id' => 'required|exists:class_member_statuses,id'
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status siswa berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $mentorId = auth()->id();

        $member = ClassMember::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dikeluarkan dari kelas'
        ]);
    }

    public function bulkApprove(Request $request)
    {
        $mentorId = auth()->id();
        $memberIds = $request->input('member_ids', []);

        $approvedStatus = ClassMemberStatus::where('name', 'approved')->first();

        if (!$approvedStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Status approved tidak ditemukan'
            ], 404);
        }

        ClassMember::whereIn('id', $memberIds)
            ->whereHas('classRoom', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })
            ->update(['status_id' => $approvedStatus->id]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil disetujui'
        ]);
    }

    public function bulkReject(Request $request)
    {
        $mentorId = auth()->id();
        $memberIds = $request->input('member_ids', []);

        $rejectedStatus = ClassMemberStatus::where('name', 'rejected')->first();

        if (!$rejectedStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Status rejected tidak ditemukan'
            ], 404);
        }

        ClassMember::whereIn('id', $memberIds)
            ->whereHas('classRoom', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })
            ->update(['status_id' => $rejectedStatus->id]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil ditolak'
        ]);
    }
}