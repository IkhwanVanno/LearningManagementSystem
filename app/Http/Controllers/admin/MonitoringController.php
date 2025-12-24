<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\ClassMember;
use App\Models\Exercise;
use App\Models\ExerciseResult;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $classId = $request->get('class_id');
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Activity Summary
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $newClasses = ClassRoom::whereBetween('created_at', [$startDate, $endDate])->count();
        $newMembers = ClassMember::whereBetween('joined_at', [$startDate, $endDate])->count();
        $completedExercises = ExerciseResult::whereBetween('submitted_at', [$startDate, $endDate])->count();

        // Recent Activities
        $recentUsers = User::with('role')
            ->latest()
            ->take(10)
            ->get();

        $recentMembers = ClassMember::with(['student', 'classRoom', 'status'])
            ->latest('joined_at')
            ->take(10)
            ->get();

        $recentExercises = ExerciseResult::with(['student', 'exercise.classRoom'])
            ->latest('submitted_at')
            ->take(10)
            ->get();

        // Class Performance
        $classPerformance = ClassRoom::with('status')
            ->withCount(['members', 'materials', 'exercises'])
            ->get()
            ->map(function ($class) {
                $avgScore = ExerciseResult::whereHas('exercise', function ($q) use ($class) {
                    $q->where('class_id', $class->id);
                })->avg('score') ?? 0;

                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'members_count' => $class->members_count,
                    'materials_count' => $class->materials_count,
                    'exercises_count' => $class->exercises_count,
                    'avg_score' => round($avgScore, 2),
                    'status' => $class->status->name ?? 'unknown'
                ];
            });

        // Top Students
        $topStudents = ExerciseResult::select('student_id', DB::raw('AVG(score) as avg_score'), DB::raw('COUNT(*) as total_exercises'))
            ->with('student')
            ->groupBy('student_id')
            ->orderByDesc('avg_score')
            ->take(10)
            ->get();

        // Active Mentors
        $activeMentors = User::whereHas('role', function ($q) {
            $q->where('name', 'mentor');
        })
            ->withCount([
                'mentorClasses',
                'mentorClasses as active_classes' => function ($q) {
                    $q->whereHas('status', function ($sq) {
                        $sq->where('name', 'active');
                    });
                }
            ])
            ->get();

        // Classes for filter
        $classes = ClassRoom::select('id', 'title')->get();

        return view('admin.monitoring', compact(
            'newUsers',
            'newClasses',
            'newMembers',
            'completedExercises',
            'recentUsers',
            'recentMembers',
            'recentExercises',
            'classPerformance',
            'topStudents',
            'activeMentors',
            'classes',
            'startDate',
            'endDate'
        ));
    }
}