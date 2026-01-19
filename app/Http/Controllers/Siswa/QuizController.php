<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':siswa']);
    }

    // List published quizzes
    public function index()
    {
        $quizzes = Quiz::where('is_published', true)
            ->with('category','creator')
            ->latest()
            ->paginate(12);

        return view('siswa.quizzes.index', compact('quizzes'));
    }

    // Show quiz detail (sebelum mulai) — tetap seperti semula
    public function show(Quiz $quiz)
    {
        if (! $quiz->is_published) abort(404);
        $quiz->load('questions.choices');
        return view('siswa.quizzes.show', compact('quiz'));
    }

    /**
     * START / HALAMAN NGERJAIN (Attempt)
     * URL: /siswa/quizzes/{quiz}/start
     */
    public function start(Quiz $quiz)
    {
        if (! $quiz->is_published) abort(404);

        // pastikan load choices untuk setiap question
        $quiz->load(['questions' => function ($q) {
            $q->with('choices')->orderBy('id');
        }]);

        return view('siswa.quizzes.attempt', compact('quiz'));
    }

    /**
     * SUBMIT jawaban sederhana (stub grading)
     * URL: POST /siswa/quizzes/{quiz}/submit
     */
    public function submit(Request $request, Quiz $quiz)
    {
        if (! $quiz->is_published) abort(404);

        $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $request->input('answers', []);
        $correct = 0;

        // hitung benar berdasarkan label (A/B/C..)
        foreach ($quiz->questions as $question) {
            $qid = (string)$question->id;
            if (! isset($answers[$qid])) continue;
            $selectedLabel = $answers[$qid];
            $choice = $question->choices()->where('label', $selectedLabel)->first();
            if ($choice && $choice->is_correct) $correct++;
        }

        $total = $quiz->questions->count();

        // di sini kamu bisa simpan result / attempt ke DB — sekarang hanya redirect
        return redirect()->route('siswa.quiz.index')
            ->with('success', "Quiz selesai. Nilai: {$correct}/{$total}");
    }
}
