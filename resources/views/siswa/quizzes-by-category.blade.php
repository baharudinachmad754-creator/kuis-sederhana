@extends('layouts.app')

@section('title', 'Daftar Quiz')

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
   BACK LINK
====================================================================== */
.back {
    display: inline-block;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 600;
    color: #6366f1;
    text-decoration: none;
}

.back:hover {
    text-decoration: underline;
}

/* ======================================================================
   QUIZ GRID
====================================================================== */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

/* ======================================================================
   QUIZ CARD
====================================================================== */
.quiz {
    position: relative;
    padding: 26px;
    border-radius: 22px;
    background: rgba(255,255,255,.88);
    border: 1px solid #e0e7ff;
    overflow: hidden;
    transition: all .25s ease;
}

.quiz::before {
    content:"";
    position:absolute;
    inset:0;
    background: linear-gradient(
        135deg,
        rgba(99,102,241,.15),
        rgba(34,211,238,.15)
    );
    opacity:0;
    transition:.3s;
}

.quiz:hover::before {
    opacity:1;
}

.quiz:hover {
    transform: translateY(-6px);
    box-shadow: 0 22px 44px rgba(99,102,241,.35);
}

.quiz h3 {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
    position: relative;
    z-index: 1;
}

.quiz p {
    font-size: 14px;
    color: #475569;
    margin-top: 6px;
    position: relative;
    z-index: 1;
}

/* ======================================================================
   BUTTON
====================================================================== */
.play {
    margin-top: 18px;
    display: inline-block;
    padding: 10px 20px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    text-decoration: none;
    box-shadow: 0 10px 22px rgba(99,102,241,.45);
    position: relative;
    z-index: 1;
    transition: .2s;
}

.play:hover {
    transform: translateY(-2px);
}

/* ======================================================================
   BADGE
====================================================================== */
.badge {
    position:absolute;
    top:18px;
    right:18px;
    padding:4px 10px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
    color:#fff;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow:0 6px 14px rgba(99,102,241,.4);
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

/* ======================================================================
   RESPONSIVE
====================================================================== */
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

        <a href="{{ route('siswa.dashboard') }}" class="back">
            ← Kembali
        </a>

        <div class="header">
            <div class="logo">Q</div>
            <h1>Quiz {{ $category->name }} 📝</h1>
            <p>Pilih quiz dan mulai tantangan</p>
        </div>

        @if($quizzes->isEmpty())
            <div class="empty">
                Belum ada quiz di mata pelajaran ini 😴
            </div>
        @else
            <div class="grid">
                @foreach($quizzes as $quiz)
                    <div class="quiz">
                        <span class="badge">{{ $quiz->total_questions }} Soal</span>

                        <h3>{{ $quiz->title }}</h3>
                        <p>Uji pemahamanmu dengan quiz ini</p>

                        <a href="{{ route('siswa.quiz.play', $quiz->id) }}" class="play">
                            Kerjakan 🚀
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

@endsection
