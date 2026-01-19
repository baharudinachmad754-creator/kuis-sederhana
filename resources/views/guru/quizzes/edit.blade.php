@extends('layouts.app')

@section('title', 'Kelola Quiz')

@section('content')

<style>
/* ======================================================================
   BACKGROUND — SAME THEME
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
    from { filter: hue-rotate(0deg); }
    to   { filter: hue-rotate(15deg); }
}

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
   MAIN CARD
====================================================================== */
.card {
    width: 100%;
    max-width: 1100px;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(18px);
    border-radius: 28px;
    padding: 42px;
    box-shadow:
        0 30px 60px rgba(0,0,0,.12),
        inset 0 1px 0 rgba(255,255,255,.6);
    animation: pop .8s ease;
}

@keyframes pop {
    from { opacity:0; transform:scale(.96) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}

/* ======================================================================
   HEADER
====================================================================== */
.header {
    text-align: center;
    margin-bottom: 36px;
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
    box-shadow: 0 12px 24px rgba(99,102,241,.4);
}

.header h1 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
}

.header p {
    font-size: 14px;
    color: #475569;
    margin-top: 6px;
}

/* ======================================================================
   ACTION BAR
====================================================================== */
.actions {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-bottom: 30px;
}

.action-btn {
    padding: 10px 22px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow: 0 10px 22px rgba(99,102,241,.45);
    transition: .2s;
    border: none;
    cursor: pointer;
}

.action-btn.green {
    background: linear-gradient(135deg,#059669,#34d399);
    box-shadow: 0 10px 22px rgba(16,185,129,.45);
}

.action-btn:hover {
    transform: translateY(-2px);
}

/* ======================================================================
   QUESTION LIST
====================================================================== */
.quiz {
    position: relative;
    padding: 26px;
    border-radius: 22px;
    background: rgba(255,255,255,.88);
    border: 1px solid #e0e7ff;
    margin-bottom: 16px;
}

.quiz h3 {
    font-size: 16px;
    font-weight: 800;
    color: #1e293b;
}

.quiz p {
    font-size: 14px;
    color: #475569;
    margin-top: 6px;
}

/* ======================================================================
   QUIZ ACTION
====================================================================== */
.quiz-actions {
    margin-top: 14px;
    display: flex;
    gap: 10px;
}

.quiz-actions a,
.quiz-actions button {
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.edit {
    background: linear-gradient(135deg,#6366f1,#22d3ee);
}

.delete {
    background: #ef4444;
}

/* ======================================================================
   EMPTY
====================================================================== */
.empty {
    text-align:center;
    font-size:14px;
    color:#64748b;
    padding:40px 0;
}

@media(max-width:480px){
    .card { padding:28px 22px; }
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
        <h1>Kelola Quiz 🛠️</h1>
        <p>{{ $quiz->title }} • {{ $quiz->questions->count() }} Soal</p>
    </div>

    <div class="actions">
        <a href="{{ route('guru.quizzes.questions.create', $quiz->id) }}"
           class="action-btn">
            + Tambah Soal
        </a>

        <form action="{{ route('guru.quizzes.publish', $quiz->id) }}"
              method="POST"
              onsubmit="return confirm('Publish quiz sekarang?')">
            @csrf
            <button class="action-btn green">
                Selesai & Publish
            </button>
        </form>
    </div>

    @if($quiz->questions->isEmpty())
        <div class="empty">
            Belum ada soal di quiz ini 😴
        </div>
    @else
        @foreach($quiz->questions as $i => $question)
            <div class="quiz">
                <h3>Soal {{ $i+1 }}</h3>
                <p>{{ \Illuminate\Support\Str::limit($question->question_text,120) }}</p>

                <div class="quiz-actions">
                    <a href="{{ route('guru.quizzes.questions.edit', [$quiz->id,$question->id]) }}"
                       class="edit">
                        Edit
                    </a>

                    <form action="{{ route('guru.quizzes.questions.destroy', [$quiz->id,$question->id]) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus soal ini?')">
                        @csrf @method('DELETE')
                        <button class="delete">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

</div>
</div>

@endsection
