<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassMember;
use App\Models\ExerciseResult;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();

        // Statistics
        $totalClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })->count();

        $pendingClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'pending');
            })->count();

        $totalSubmissions = ExerciseResult::where('student_id', $studentId)->count();

        $averageScore = ExerciseResult::where('student_id', $studentId)
            ->whereNotNull('score')
            ->avg('score') ?? 0;

        // My Classes (Approved)
        $myClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->with(['classRoom.mentor', 'classRoom.status'])
            ->latest('joined_at')
            ->take(6)
            ->get();

        // Recent Activities (submissions)
        $recentActivities = ExerciseResult::where('student_id', $studentId)
            ->with(['exercise.classRoom'])
            ->latest('submitted_at')
            ->take(8)
            ->get();

        // Pending Exercises (not yet submitted)
        $pendingExercises = DB::table('exercises')
            ->join('classes', 'exercises.class_id', '=', 'classes.id')
            ->join('class_members', 'classes.id', '=', 'class_members.class_id')
            ->leftJoin('exercise_results', function ($join) use ($studentId) {
                $join->on('exercises.id', '=', 'exercise_results.exercise_id')
                    ->where('exercise_results.student_id', '=', $studentId);
            })
            ->where('class_members.student_id', $studentId)
            ->whereNull('exercise_results.id')
            ->select('exercises.*', 'classes.title as class_title')
            ->latest('exercises.created_at')
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalClasses',
            'pendingClasses',
            'totalSubmissions',
            'averageScore',
            'myClasses',
            'recentActivities',
            'pendingExercises'
        ));
    }
}