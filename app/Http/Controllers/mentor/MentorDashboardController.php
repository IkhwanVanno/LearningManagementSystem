<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassMember;
use App\Models\Exercise;
use App\Models\ExerciseResult;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $mentorId = auth()->id();

        // Statistics
        $totalClasses = ClassRoom::where('mentor_id', $mentorId)->count();

        $activeClasses = ClassRoom::where('mentor_id', $mentorId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'active');
            })->count();

        $totalStudents = ClassMember::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->count();

        $totalMaterials = Material::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->count();

        $totalExercises = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->count();

        $pendingSubmissions = ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->whereNull('score')->count();

        // My Classes
        $myClasses = ClassRoom::where('mentor_id', $mentorId)
            ->with(['status', 'members'])
            ->withCount(['members', 'materials', 'exercises'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Activities
        $recentMembers = ClassMember::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['student', 'classRoom', 'status'])
            ->latest('joined_at')
            ->take(8)
            ->get();

        // Recent Submissions
        $recentSubmissions = ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['student', 'exercise'])
            ->latest('submitted_at')
            ->take(8)
            ->get();

        // Class Performance
        $classPerformance = ClassRoom::where('mentor_id', $mentorId)
            ->withCount('members')
            ->get()
            ->map(function ($class) {
                $avgScore = ExerciseResult::whereHas('exercise', function ($q) use ($class) {
                    $q->where('class_id', $class->id);
                })->avg('score') ?? 0;

                return [
                    'title' => $class->title,
                    'members' => $class->members_count,
                    'avg_score' => round($avgScore, 2)
                ];
            });

        return view('mentor.dashboard', compact(
            'totalClasses',
            'activeClasses',
            'totalStudents',
            'totalMaterials',
            'totalExercises',
            'pendingSubmissions',
            'myClasses',
            'recentMembers',
            'recentSubmissions',
            'classPerformance'
        ));
    }
}