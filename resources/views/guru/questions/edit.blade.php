@extends('layouts.app')

@section('content')

<style>
/* ======================================================================
   RESET
====================================================================== */
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* ======================================================================
   BACKGROUND
====================================================================== */
.bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background:
        radial-gradient(circle at 20% 20%, #fde68a 0%, transparent 35%),
        radial-gradient(circle at 80% 30%, #93c5fd 0%, transparent 40%),
        radial-gradient(circle at 50% 80%, #a7f3d0 0%, transparent 40%),
        linear-gradient(135deg, #fdf4ff, #eef2ff);
    animation: bgMove 20s ease-in-out infinite alternate;
}

@keyframes bgMove {
    0% { filter: hue-rotate(0deg); }
    100% { filter: hue-rotate(15deg); }
}

/* floating shapes */
.shape {
    position: fixed;
    border-radius: 50%;
    opacity: .45;
    filter: blur(20px);
    animation: float 14s infinite ease-in-out;
    z-index: 1;
}

.shape.one {
    width: 260px;
    height: 260px;
    background: #60a5fa;
    top: 10%;
    left: 8%;
}

.shape.two {
    width: 220px;
    height: 220px;
    background: #34d399;
    top: 65%;
    left: 70%;
    animation-delay: 3s;
}

.shape.three {
    width: 180px;
    height: 180px;
    background: #f472b6;
    top: 20%;
    right: 10%;
    animation-delay: 6s;
}

@keyframes float {
    0% { transform: translate(0,0); }
    50% { transform: translate(20px,-30px); }
    100% { transform: translate(0,0); }
}

/* ======================================================================
   WRAPPER
====================================================================== */
.wrapper {
    position: relative;
    z-index: 5;
    min-height: 100vh;
    padding: 50px 24px;
    display: flex;
    justify-content: center;
}

/* ======================================================================
   CARD
====================================================================== */
.card {
    width: 100%;
    max-width: 900px;
    background: rgba(255,255,255,0.78);
    backdrop-filter: blur(18px);
    border-radius: 28px;
    padding: 40px;
    box-shadow:
        0 30px 60px rgba(0,0,0,0.12),
        inset 0 1px 0 rgba(255,255,255,0.6);
    animation: pop .8s ease;
}

@keyframes pop {
    from { opacity: 0; transform: scale(.96) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* ======================================================================
   HEADER
====================================================================== */
.header {
    text-align: center;
    margin-bottom: 30px;
}

.logo {
    width: 56px;
    height: 56px;
    margin: 0 auto 14px;
    border-radius: 16px;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    display: grid;
    place-items: center;
    color: white;
    font-weight: 900;
    font-size: 22px;
    box-shadow: 0 12px 24px rgba(99,102,241,0.4);
}

.header h1 {
    font-size: 26px;
    font-weight: 800;
    color: #1e293b;
}

.header p {
    font-size: 14px;
    color: #475569;
    margin-top: 6px;
}

/* ======================================================================
   FORM
====================================================================== */
.form-group {
    margin-bottom: 14px;
}

label {
    display: block;
    font-weight: 700;
    margin-bottom: 6px;
    color: #1e293b;
}

input,
textarea {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

input:focus,
textarea:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.25);
}

.choice {
    display: flex;
    gap: 10px;
    align-items: center;
}

.choice-key {
    width: 36px;
    font-weight: 800;
    color: #6366f1;
}

/* ======================================================================
   BUTTON
====================================================================== */
.actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    flex-wrap: wrap;
}

.btn {
    padding: 14px 20px;
    border-radius: 16px;
    border: none;
    cursor: pointer;
    font-weight: 800;
    font-size: 14px;
    color: #fff;
    transition: all .25s ease;
}

.btn-save {
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow: 0 16px 36px rgba(99,102,241,.45);
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 22px 44px rgba(99,102,241,.6);
}

.link {
    align-self: center;
    font-weight: 700;
    color: #6366f1;
    text-decoration: none;
}
</style>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
    <div class="card">

        <div class="header">
            <div class="logo">Q</div>
            <h1>Edit Soal</h1>
            <p>{{ $quiz->title }}</p>
        </div>

        @if ($errors->any())
            <div style="background:#FEF2F2;padding:14px;border-radius:14px;color:#991B1B;margin-bottom:20px">
                <ul style="padding-left:18px">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('guru.quizzes.questions.update', [$quiz->id, $question->id]) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Soal</label>
                <textarea name="question_text" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            @if($question->image)
                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <img src="{{ asset('storage/'.$question->image) }}"
                         style="max-height:240px;border-radius:16px;border:1px solid #e5e7eb">
                </div>
            @endif

            <div class="form-group">
                <label>Ganti Gambar (opsional)</label>
                <input type="file" name="image" accept="image/*">
            </div>

            @foreach($question->choices as $i => $choice)
                <div class="form-group choice">
                    <div class="choice-key">{{ $choice->label }}</div>

                    <input type="text"
                           name="choices[{{ $i }}]"
                           value="{{ old('choices.'.$i, $choice->choice_text) }}"
                           required>

                    <input type="radio"
                           name="correct_index"
                           value="{{ $i }}"
                           {{ $choice->is_correct ? 'checked' : '' }}>
                </div>
            @endforeach

            <div class="actions">
                <button type="submit" class="btn btn-save">
                    💾 Simpan Perubahan
                </button>

                <a href="{{ route('guru.quizzes.edit', $quiz->id) }}" class="link">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
