<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Category;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function index()
    {
        $quizzes = Quiz::where('created_by', auth()->id())
            ->with('category')
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('guru.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('guru.quizzes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'token'       => 'required|string|max:50',
            'duration'    => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create([
            'category_id'     => $request->category_id,
            'created_by'      => auth()->id(),
            'title'           => $request->title,
            'description'     => $request->description,
            'token'           => $request->token,
            'duration'        => $request->duration,
            'is_published'    => false,
            'total_questions' => 0,
        ]);

        return redirect()
            ->route('guru.quizzes.questions.create', $quiz->id)
            ->with('success', 'Quiz dibuat. Tambahkan soal.');
    }

    public function edit(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);

        $quiz->load('questions.choices','category');
        return view('guru.quizzes.edit', compact('quiz'));
    }

    public function publish(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);

        if ($quiz->questions()->count() === 0) {
            return back()->withErrors(['msg' => 'Minimal 1 soal untuk publish']);
        }

        $quiz->update([
            'total_questions' => $quiz->questions()->count(),
            'is_published'    => true
        ]);

        return redirect()
            ->route('guru.quizzes.index')
            ->with('success', 'Quiz dipublish.');
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);

        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()
            ->route('guru.quizzes.index')
            ->with('success','Quiz dihapus.');
    }
}
