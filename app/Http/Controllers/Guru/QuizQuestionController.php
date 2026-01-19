<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Support\Facades\Storage;

class QuizQuestionController extends Controller
{
    /**
     * FORM TAMBAH SOAL
     */
    public function create(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        $questionNumber = $quiz->questions()->count() + 1;

        return view('guru.questions.create', compact('quiz', 'questionNumber'));
    }

    /**
     * SIMPAN SOAL BARU
     */
    public function store(Request $request, Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'question_text' => 'required|string',
            'choices'       => 'required|array|min:2',
            'choices.*'     => 'required|string',
            'correct_index' => 'required|integer',
            'image'         => 'nullable|image|max:2048',
        ]);

        // 🔥 SIMPAN GAMBAR
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('questions', 'public');
        }

        $question = Question::create([
            'quiz_id'       => $quiz->id,
            'category_id'   => 1,
            'created_by'    => auth()->id(),
            'question_text' => $request->question_text,
            'image'         => $imagePath,
        ]);

        $labels = ['A','B','C','D','E','F'];

        foreach ($request->choices as $i => $text) {
            Choice::create([
                'question_id' => $question->id,
                'label'       => $labels[$i],
                'choice_text' => $text,
                'is_correct'  => $i == $request->correct_index,
            ]);
        }

        $quiz->update([
            'total_questions' => $quiz->questions()->count()
        ]);

        return redirect()
            ->route('guru.quizzes.edit', $quiz->id)
            ->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * FORM EDIT SOAL
     */
    public function edit(Quiz $quiz, Question $question)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);
        if ($question->quiz_id !== $quiz->id) abort(404);

        $question->load('choices');

        return view('guru.questions.edit', compact('quiz', 'question'));
    }

    /**
     * UPDATE SOAL
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'question_text' => 'required|string',
            'choices'       => 'required|array|min:2',
            'choices.*'     => 'required|string',
            'correct_index' => 'required|integer',
            'image'         => 'nullable|image|max:2048',
        ]);

        // 🔥 JIKA GANTI GAMBAR
        if ($request->hasFile('image')) {
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            $question->image = $request->file('image')
                ->store('questions', 'public');
        }

        $question->question_text = $request->question_text;
        $question->save();

        // hapus pilihan lama
        $question->choices()->delete();

        $labels = ['A','B','C','D','E','F'];

        foreach ($request->choices as $i => $text) {
            Choice::create([
                'question_id' => $question->id,
                'label'       => $labels[$i],
                'choice_text' => $text,
                'is_correct'  => $i == $request->correct_index,
            ]);
        }

        return redirect()
            ->route('guru.quizzes.edit', $quiz->id)
            ->with('success', 'Soal berhasil diperbarui');
    }

    /**
     * HAPUS SOAL
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        $question->delete();

        $quiz->update([
            'total_questions' => $quiz->questions()->count()
        ]);

        return back()->with('success', 'Soal dihapus');
    }
}
