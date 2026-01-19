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
    from { filter: hue-rotate(0); }
    to   { filter: hue-rotate(15deg); }
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
.shape.one { width:260px;height:260px;background:#60a5fa;top:10%;left:8%; }
.shape.two { width:220px;height:220px;background:#34d399;top:65%;left:70%;animation-delay:3s; }
.shape.three{ width:180px;height:180px;background:#f472b6;top:20%;right:10%;animation-delay:6s; }

@keyframes float {
    0%{transform:translate(0,0)}
    50%{transform:translate(20px,-30px)}
    100%{transform:translate(0,0)}
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
    align-items: center;
}

/* ======================================================================
   MAIN CARD
====================================================================== */
.card {
    width: 100%;
    max-width: 700px;
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(18px);
    border-radius: 28px;
    padding: 42px;
    box-shadow:
        0 30px 60px rgba(0,0,0,.12),
        inset 0 1px 0 rgba(255,255,255,.6);
    text-align: center;
    animation: pop .8s ease;
}

@keyframes pop {
    from { opacity:0; transform:scale(.96) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}

/* ======================================================================
   HEADER
====================================================================== */
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

h2 {
    font-size: 26px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 6px;
}

.quiz-title {
    font-size: 14px;
    color: #475569;
    margin-bottom: 26px;
}

/* ======================================================================
   SCORE
====================================================================== */
.score {
    font-size: 56px;
    font-weight: 900;
    color: #4f46e5;
    margin-bottom: 6px;
}

.score-desc {
    color: #374151;
    margin-bottom: 32px;
}

/* ======================================================================
   INFO GRID
====================================================================== */
.info {
    display: flex;
    justify-content: center;
    gap: 36px;
    margin-bottom: 34px;
}

.info div {
    text-align: center;
}

.info span {
    font-size: 12px;
    color: #6b7280;
}

.info strong {
    display: block;
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-top: 4px;
}

/* ======================================================================
   BUTTON
====================================================================== */
.btn {
    display: inline-block;
    padding: 14px 32px;
    border-radius: 999px;
    font-weight: 700;
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow: 0 16px 34px rgba(99,102,241,.45);
    transition: .25s;
}

.btn:hover {
    transform: translateY(-2px);
}
</style>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
    <div class="card">

        <div class="logo">Q</div>

        <h2>Quiz Selesai 🎉</h2>
        <div class="quiz-title">{{ $quiz->title }}</div>

        <div class="score">{{ $attempt->score }}</div>
        <div class="score-desc">
            dari {{ $attempt->total_questions }} soal
        </div>

        <div class="info">
            <div>
                <span>Mulai</span>
                <strong>{{ $attempt->started_at->format('H:i') }}</strong>
            </div>
            <div>
                <span>Selesai</span>
                <strong>{{ $attempt->finished_at->format('H:i') }}</strong>
            </div>
            <div>
                <span>Durasi</span>
                <strong>{{ $attempt->started_at->diffInMinutes($attempt->finished_at) }} menit</strong>
            </div>
        </div>

        <a href="{{ route('siswa.dashboard') }}" class="btn">
            Kembali ke Dashboard
        </a>

    </div>
</div>

@endsection
