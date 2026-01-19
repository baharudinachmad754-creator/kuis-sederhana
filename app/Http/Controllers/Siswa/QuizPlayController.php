<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizPlayController extends Controller
{
    public function play(Quiz $quiz)
    {
        // Load questions + choices supaya langsung bisa di-loop di Blade
        $quiz->load('questions.choices');

        // bikin attempt saat mulai
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'total_questions' => $quiz->questions->count(),
            'started_at' => now(),
        ]);

        // kalau quiz pakai token
    if ($quiz->token) {
        return view('siswa.quiz.token', compact('quiz'));
        }
         return view('siswa.quiz.play', compact('quiz'));
    }

     public function verifyToken(Request $request, Quiz $quiz)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if ($request->token !== $quiz->token) {
            return back()->withErrors([
                'token' => 'Token salah'
            ]);
        }

        return view('siswa.play', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
{
    $quiz->load('questions.choices');

    $attempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('user_id', auth()->id())
        ->latest()
        ->firstOrFail();

    $totalQuestions = $quiz->questions->count();
    $correctCount = 0;
    $answers = [];

    foreach ($quiz->questions as $question) {
        $userAnswer = $request->input('answers.' . $question->id);
        $answers[$question->id] = $userAnswer;

        $correctChoice = $question->choices->firstWhere('is_correct', true);
        if ($correctChoice && $userAnswer == $correctChoice->id) {
            $correctCount++;
        }
    }

    // Hitung skor proporsional
    $score = ($totalQuestions > 0) ? round((100 / $totalQuestions) * $correctCount) : 0;

    $attempt->update([
        'score' => $score,
        'finished_at' => now(),
        'meta' => [
            'answers' => $answers,
        ],
    ]);

    return view('siswa.result', compact('quiz', 'attempt'));
}}