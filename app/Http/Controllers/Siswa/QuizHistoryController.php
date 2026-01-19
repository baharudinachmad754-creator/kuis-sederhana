<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizHistoryController extends Controller
{
    /**
     * Tampilkan history quiz siswa
     */
    public function index()
    {
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('siswa.history', compact('attempts'));
    }
}
