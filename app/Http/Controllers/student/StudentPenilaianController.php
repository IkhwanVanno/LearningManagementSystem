<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ExerciseResult;
use App\Models\ClassMember;
use Illuminate\Http\Request;

class StudentPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $studentId = auth()->id();
        $classId = $request->get('class_id');

        // Get results
        $query = ExerciseResult::where('student_id', $studentId)
            ->with(['exercise.classRoom']);

        if ($classId) {
            $query->whereHas('exercise', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $results = $query->latest('submitted_at')->paginate(15);

        // Get student's classes for filter
        $myClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->with('classRoom')
            ->get()
            ->pluck('classRoom');

        // Statistics
        $stats = [
            'total_submissions' => ExerciseResult::where('student_id', $studentId)->count(),
            'graded' => ExerciseResult::where('student_id', $studentId)
                ->whereNotNull('score')
                ->count(),
            'average_score' => ExerciseResult::where('student_id', $studentId)
                ->whereNotNull('score')
                ->avg('score') ?? 0,
            'highest_score' => ExerciseResult::where('student_id', $studentId)
                ->whereNotNull('score')
                ->max('score') ?? 0
        ];

        return view('student.penilaian', compact('results', 'myClasses', 'stats'));
    }

    public function detail($id)
    {
        $studentId = auth()->id();

        $result = ExerciseResult::where('id', $id)
            ->where('student_id', $studentId)
            ->with([
                'exercise.questions',
                'exercise.classRoom',
                'student'
            ])
            ->firstOrFail();

        // Get student's answers
        $studentAnswers = $result->student->answers()
            ->whereHas('question', function ($q) use ($result) {
                $q->where('exercise_id', $result->exercise_id);
            })
            ->with('question')
            ->get()
            ->keyBy('question_id');

        return view('student.penilaian-detail', compact('result', 'studentAnswers'));
    }
}