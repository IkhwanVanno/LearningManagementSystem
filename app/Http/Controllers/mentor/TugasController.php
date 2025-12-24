<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $mentorId = auth()->id();
        $classId = $request->get('class_id');

        $query = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->with(['classRoom', 'questions']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $exercises = $query->withCount('questions')->latest()->paginate(12);

        $classes = ClassRoom::where('mentor_id', $mentorId)
            ->select('id', 'title')
            ->get();

        return view('mentor.tugas', compact('exercises', 'classes'));
    }

    public function store(Request $request)
    {
        $mentorId = auth()->id();

        // Verify class belongs to mentor
        ClassRoom::where('mentor_id', $mentorId)
            ->where('id', $request->class_id)
            ->firstOrFail();

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $exercise = Exercise::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan',
            'data' => $exercise
        ]);
    }

    public function show($id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['classRoom', 'questions'])
            ->findOrFail($id);

        return response()->json($exercise);
    }

    public function edit($id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->with(['classRoom', 'questions'])
            ->findOrFail($id);

        return view('mentor.tugas-edit', compact('exercise'));
    }

    public function update(Request $request, $id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $exercise->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $exercise->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }

    // Question Management
    public function storeQuestion(Request $request, $id)
    {
        $mentorId = auth()->id();

        $exercise = Exercise::whereHas('classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($id);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D'
        ]);

        $validated['exercise_id'] = $exercise->id;

        Question::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil ditambahkan'
        ]);
    }

    public function updateQuestion(Request $request, $questionId)
    {
        $mentorId = auth()->id();

        $question = Question::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($questionId);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D'
        ]);

        $question->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diupdate'
        ]);
    }

    public function destroyQuestion($questionId)
    {
        $mentorId = auth()->id();

        $question = Question::whereHas('exercise.classRoom', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->findOrFail($questionId);

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil dihapus'
        ]);
    }
}