@extends('layouts.app')

@section('title', 'History Quiz')

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
    max-width: 1000px;
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
    margin-bottom: 34px;
}

.logo {
    width: 56px;
    height: 56px;
    margin: 0 auto 14px;
    border-radius: 16px;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    display: grid;
    place-items: center;
    color: #fff;
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
   HISTORY LIST
====================================================================== */
.history {
    display: grid;
    gap: 18px;
}

.item {
    position: relative;
    padding: 22px 26px;
    border-radius: 20px;
    background: rgba(255,255,255,.85);
    border: 1px solid #e0e7ff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all .25s ease;
}

.item:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(99,102,241,.3);
}

.item h3 {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
}

.item p {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}

.score {
    min-width: 90px;
    height: 42px;
    border-radius: 999px;
    display: grid;
    place-items: center;
    font-weight: 900;
    font-size: 15px;
    color: white;
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow: 0 10px 22px rgba(99,102,241,.45);
}

/* ======================================================================
   EMPTY
====================================================================== */
.empty {
    text-align: center;
    color: #64748b;
    font-size: 14px;
    padding: 40px 0;
}

/* ======================================================================
   RESPONSIVE
====================================================================== */
@media (max-width: 640px) {
    .item {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
    }
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
            <h1>History Quiz 📊</h1>
            <p>Lihat hasil quiz yang sudah kamu kerjakan</p>
        </div>

        @if($attempts->isEmpty())
            <div class="empty">
                Belum ada history quiz 😴
            </div>
        @else
            <div class="history">
                @foreach($attempts as $attempt)
                    <div class="item">
                        <div>
                            <h3>{{ $attempt->quiz->title }}</h3>
                            <p>
                                {{ $attempt->created_at->format('d M Y • H:i') }}
                            </p>
                        </div>
                        <div class="score">
                            {{ $attempt->score ?? 0 }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

@endsection
