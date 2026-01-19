<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizHistoryController extends Controller
{
    // STEP 1 — SEMUA MAPEL
    public function index()
    {
        $categories = Category::all();

        return view('guru.history.index', compact('categories'));
    }

    // STEP 2 — QUIZ DALAM MAPEL
    public function quizzes(Category $category)
    {
        $quizzes = Quiz::where('category_id', $category->id)
            ->where('created_by', auth()->id())
            ->get();

        return view('guru.history.quizzes', compact('category', 'quizzes'));
    }

    // STEP 3 — FORM TOKEN
    public function tokenForm(Quiz $quiz)
    {
        return view('guru.history.token', compact('quiz'));
    }

    // STEP 4 — VERIFY TOKEN + TAMPIL HISTORY
    public function verifyToken(Request $request, Quiz $quiz)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if ($request->token !== $quiz->token) {
            return back()->withErrors(['token' => 'Token salah']);
        }

        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->with('user')
            ->get();

        return view('guru.history.attempts', compact('quiz', 'attempts'));
    }
    
public function destroy(QuizAttempt $attempt)
{
    $quizId = $attempt->quiz_id;

    $attempt->delete();

    return redirect()
        ->route('guru.history.token', $quizId)
        ->with('success', 'History siswa berhasil dihapus');
}

}