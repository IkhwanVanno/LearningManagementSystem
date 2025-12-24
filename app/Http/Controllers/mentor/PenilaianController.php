<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Exercise;
use App\Models\ExerciseResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $mentorId = auth()->id();
        $classId = $request->get('class_id');
        $exerciseId = $request->get('exercise_id');

        // Get mentor's classes
        $classes = ClassRoom::where('mentor_id', $mentorId)
            ->select('id', 'title')
            ->get();

        // Get exercises based on selected class
        $exercisesQuery = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        });

        if ($classId) {
            $exercisesQuery->where('class_id', $classId);
        }

        $exercises = $exercisesQuery->select('id', 'title', 'class_id')->get();

        // Get results
        $resultsQuery = ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->with(['student', 'exercise']);

        if ($exerciseId) {
            $resultsQuery->where('exercise_id', $exerciseId);
        } elseif ($classId) {
            $resultsQuery->whereHas('exercise', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $results = $resultsQuery->latest('submitted_at')->paginate(15);

        // Statistics
        $stats = [
            'total_submissions' => ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })->count(),
            'pending_reviews' => ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })->whereNull('score')->count(),
            'average_score' => ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })->whereNotNull('score')->avg('score') ?? 0
        ];

        return view('mentor.penilaian', compact('results', 'classes', 'exercises', 'stats', 'classId', 'exerciseId'));
    }

    public function showExerciseResults($id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['classRoom', 'questions'])
            ->withCount('questions')
            ->findOrFail($id);

        $results = ExerciseResult::where('exercise_id', $id)
            ->with(['student'])
            ->latest('submitted_at')
            ->get();

        // Calculate statistics
        $stats = [
            'total_students' => $exercise->classRoom->members()->count(),
            'submitted' => $results->count(),
            'not_submitted' => $exercise->classRoom->members()->count() - $results->count(),
            'average_score' => $results->whereNotNull('score')->avg('score') ?? 0,
            'highest_score' => $results->whereNotNull('score')->max('score') ?? 0,
            'lowest_score' => $results->whereNotNull('score')->min('score') ?? 0
        ];

        return view('mentor.penilaian-detail', compact('exercise', 'results', 'stats'));
    }

    public function updateScore(Request $request, $id)
    {
        $mentorId = auth()->id();

        $result = ExerciseResult::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100'
        ]);

        $result->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diupdate'
        ]);
    }
}