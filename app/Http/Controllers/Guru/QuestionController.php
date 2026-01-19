<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Quiz;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    /* =====================================================
       ===== SOAL DALAM QUIZ (KHUSUS)
    ===================================================== */

    public function create(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);

        $questionNumber = $quiz->questions()->count() + 1;

        return view('guru.questions.create', compact('quiz','questionNumber'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) abort(403);

        $request->validate([
            'question_text' => 'required|string',
            'choices.a' => 'required|string',
            'choices.b' => 'required|string',
            'choices.c' => 'required|string',
            'choices.d' => 'required|string',
            'choices.e' => 'nullable|string',
            'correct'   => 'required|in:a,b,c,d,e',
            'image'     => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions','public');
        }

        $question = Question::create([
            'quiz_id'       => $quiz->id,
            'created_by'    => auth()->id(),
            'question_text' => $request->question_text,
            'image'         => $imagePath,
        ]);

        foreach (['a','b','c','d','e'] as $label) {
            $text = $request->input("choices.$label");
            if (!$text) continue;

            Choice::create([
                'question_id' => $question->id,
                'label'       => $label,
                'choice_text' => $text,
                'is_correct'  => $label === $request->correct,
            ]);
        }

        if ($request->action === 'finish') {
            return redirect()
                ->route('guru.quizzes.edit', $quiz->id)
                ->with('success','Soal ditambahkan & quiz siap dipublish.');
        }

        return redirect()
            ->route('guru.quiz.questions.create', $quiz->id);
    }

    /* =====================================================
       ===== BANK SOAL (TETAP UTUH – TIDAK DIUBAH)
    ===================================================== */

    public function index()
    {
        $questions = Question::where('created_by', auth()->id())
            ->latest()
            ->paginate(15);

        return view('guru.questions.index', compact('questions'));
    }

    public function show(Question $question)
    {
        if ($question->created_by !== auth()->id()) abort(403);
        $question->load('choices');
        return view('guru.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        if ($question->created_by !== auth()->id()) abort(403);
        $choices = $question->choices->keyBy('label')->toArray();
        return view('guru.questions.edit', compact('question','choices'));
    }

    public function update(Request $request, Question $question)
    {
        if ($question->created_by !== auth()->id()) abort(403);

        $request->validate([
            'question_text' => 'required|string',
            'choices.a' => 'required|string',
            'choices.b' => 'required|string',
            'choices.c' => 'required|string',
            'choices.d' => 'required|string',
            'choices.e' => 'nullable|string',
            'correct'   => 'required|in:a,b,c,d,e',
            'image'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($question->image) Storage::disk('public')->delete($question->image);
            $question->image = $request->file('image')->store('questions','public');
        }

        $question->question_text = $request->question_text;
        $question->save();

        $question->choices()->delete();

        foreach (['a','b','c','d','e'] as $label) {
            $text = $request->input("choices.$label");
            if (!$text) continue;

            Choice::create([
                'question_id' => $question->id,
                'label' => $label,
                'choice_text' => $text,
                'is_correct' => $label === $request->correct,
            ]);
        }

        return redirect()->route('guru.questions.index')->with('success','Soal diperbarui.');
    }

    public function destroy(Question $question)
    {
        if ($question->created_by !== auth()->id()) abort(403);

        if ($question->image) Storage::disk('public')->delete($question->image);
        $question->delete();

        return back()->with('success','Soal dihapus.');
    }
}
