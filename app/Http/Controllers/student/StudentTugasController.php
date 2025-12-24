<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseResult;
use App\Models\ClassMember;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTugasController extends Controller
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

        // Get exercises
        $query = Exercise::whereIn('class_id', $approvedClassIds)
            ->with(['classRoom'])
            ->withCount('questions');

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $exercises = $query->latest()->paginate(12);

        // Check submission status for each exercise
        $exercises->each(function ($exercise) use ($studentId) {
            $exercise->result = ExerciseResult::where('exercise_id', $exercise->id)
                ->where('student_id', $studentId)
                ->first();
        });

        // Get student's classes for filter
        $myClasses = ClassMember::where('student_id', $studentId)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->with('classRoom')
            ->get()
            ->pluck('classRoom');

        return view('student.tugas', compact('exercises', 'myClasses'));
    }

    public function show($id)
    {
        $studentId = auth()->id();

        $exercise = Exercise::with(['classRoom', 'questions'])->findOrFail($id);

        // Check if student has access
        $hasAccess = ClassMember::where('student_id', $studentId)
            ->where('class_id', $exercise->class_id)
            ->whereHas('status', function ($q) {
                $q->where('name', 'approved');
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('student.tugas.index')
                ->with('error', 'Anda tidak memiliki akses ke tugas ini');
        }

        // Check if already submitted
        $result = ExerciseResult::where('exercise_id', $id)
            ->where('student_id', $studentId)
            ->first();

        if ($result) {
            return redirect()->route('student.tugas.index')
                ->with('info', 'Anda sudah mengerjakan tugas ini');
        }

        return view('student.tugas-kerjakan', compact('exercise'));
    }

    public function submit(Request $request, $id)
    {
        $studentId = auth()->id();

        $exercise = Exercise::with('questions')->findOrFail($id);

        // Check if already submitted
        $existing = ExerciseResult::where('exercise_id', $id)
            ->where('student_id', $studentId)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengerjakan tugas ini'
            ], 422);
        }

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $exercise->questions->count();

        DB::beginTransaction();
        try {
            // Save each answer
            foreach ($answers as $questionId => $selectedAnswer) {
                $question = $exercise->questions->find($questionId);

                if ($question) {
                    $isCorrect = $question->correct_answer === $selectedAnswer;
                    if ($isCorrect) {
                        $correctCount++;
                    }

                    StudentAnswer::create([
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'selected_answer' => $selectedAnswer,
                        'is_correct' => $isCorrect,
                        'answered_at' => now()
                    ]);
                }
            }

            // Calculate score
            $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

            // Save result
            ExerciseResult::create([
                'exercise_id' => $id,
                'student_id' => $studentId,
                'score' => $score,
                'submitted_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dikumpulkan',
                'score' => round($score, 2),
                'correct' => $correctCount,
                'total' => $totalQuestions
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban'
            ], 500);
        }
    }
}