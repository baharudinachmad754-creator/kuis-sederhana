@extends('layouts.app')

@section('title', $quiz->title)

@section('content')

<style>
/* ======================================================================
   BACKGROUND — SAME THEME
====================================================================== */
.bg{
    position:fixed;
    inset:0;
    z-index:0;
    background:
        radial-gradient(circle at 20% 20%, #fde68a 0%, transparent 35%),
        radial-gradient(circle at 80% 30%, #93c5fd 0%, transparent 40%),
        radial-gradient(circle at 50% 80%, #a7f3d0 0%, transparent 40%),
        linear-gradient(135deg, #fdf4ff, #eef2ff);
    animation:bgMove 20s ease-in-out infinite alternate;
}
@keyframes bgMove{
    from{filter:hue-rotate(0)}
    to{filter:hue-rotate(15deg)}
}

.shape{
    position:fixed;
    border-radius:50%;
    opacity:.45;
    filter:blur(20px);
    animation:float 14s infinite ease-in-out;
    z-index:1;
}
.shape.one{width:260px;height:260px;background:#60a5fa;top:10%;left:8%}
.shape.two{width:220px;height:220px;background:#34d399;top:65%;left:70%;animation-delay:3s}
.shape.three{width:180px;height:180px;background:#f472b6;top:20%;right:10%;animation-delay:6s}

@keyframes float{
    0%{transform:translate(0,0)}
    50%{transform:translate(20px,-30px)}
    100%{transform:translate(0,0)}
}

/* ======================================================================
   WRAPPER
====================================================================== */
.wrapper{
    position:relative;
    z-index:5;
    min-height:100vh;
    padding:50px 24px;
    display:flex;
    justify-content:center;
}

/* ======================================================================
   MAIN CARD
====================================================================== */
.card{
    width:100%;
    max-width:1000px;
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(18px);
    border-radius:28px;
    padding:42px;
    box-shadow:
        0 30px 60px rgba(0,0,0,.12),
        inset 0 1px 0 rgba(255,255,255,.6);
    animation:pop .8s ease;
}
@keyframes pop{
    from{opacity:0;transform:scale(.96) translateY(20px)}
    to{opacity:1;transform:scale(1) translateY(0)}
}

/* ======================================================================
   HEADER
====================================================================== */
.header{
    text-align:center;
    margin-bottom:36px;
}
.logo{
    width:56px;
    height:56px;
    margin:0 auto 14px;
    border-radius:16px;
    background:linear-gradient(135deg,#6366f1,#22d3ee);
    display:grid;
    place-items:center;
    color:#fff;
    font-weight:900;
    font-size:22px;
    box-shadow:0 12px 24px rgba(99,102,241,.4);
}
.header h1{
    font-size:26px;
    font-weight:800;
    color:#1e293b;
}
.header p{
    font-size:14px;
    color:#475569;
    margin-top:6px;
}

/* ======================================================================
   QUESTION CARD
====================================================================== */
.question{
    background:rgba(255,255,255,.88);
    border-radius:22px;
    padding:28px;
    margin-bottom:24px;
    border:1px solid #e0e7ff;
    box-shadow:0 12px 28px rgba(99,102,241,.12);
}
.question-title{
    font-weight:700;
    margin-bottom:16px;
    color:#1e293b;
}

/* image */
.question img{
    max-width:100%;
    border-radius:16px;
    margin-bottom:16px;
    box-shadow:0 10px 22px rgba(0,0,0,.12);
}

/* ======================================================================
   OPTION
====================================================================== */
.option{
    display:block;
    padding:12px 16px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    margin-bottom:10px;
    cursor:pointer;
    transition:.2s;
    background:#fff;
}
.option:hover{
    border-color:#6366f1;
    box-shadow:0 6px 14px rgba(99,102,241,.25);
}
.option input{
    margin-right:10px;
    accent-color:#6366f1;
}

/* ======================================================================
   SUBMIT
====================================================================== */
.submit{
    margin-top:30px;
    padding:14px 26px;
    border-radius:999px;
    border:none;
    cursor:pointer;
    font-size:15px;
    font-weight:800;
    color:#fff;
    background:linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow:0 16px 34px rgba(99,102,241,.5);
}
.submit:hover{transform:translateY(-2px)}
</style>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
<div class="card">

    <div class="header">
        <div class="logo">Q</div>
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description }}</p>
    </div>

    @if($quiz->duration)
<div id="timer-box" style="
    text-align:center;
    margin-bottom:30px;
    font-size:20px;
    font-weight:800;
    color:#ef4444;
">
    ⏳ Waktu tersisa:
    <span id="time">--:--</span>
</div>
@endif


    <form id="quiz-form" method="POST" action="{{ route('siswa.quiz.submit', $quiz->id) }}">
        @csrf

        @foreach($quiz->questions as $question)
            <div class="question">
                <div class="question-title">
                    {{ $loop->iteration }}. {{ $question->question_text }}
                </div>

                {{-- GAMBAR --}}
                @if($question->image)
                    <img src="{{ asset('storage/'.$question->image) }}">
                @endif

                @foreach($question->choices as $choice)
                    <label class="option">
                        <input type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $choice->id }}"
                            required>
                        {{ $choice->choice_text }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <button class="submit">Submit Jawaban 🚀</button>
    </form>

</div>
</div>

@if($quiz->duration)
<script>
    let time = {{ $quiz->duration }} * 60; // menit → detik

    const timerEl = document.getElementById('time');
    const form = document.getElementById('quiz-form');

    const countdown = setInterval(() => {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;

        timerEl.textContent =
            minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        time--;

        if (time < 0) {
            clearInterval(countdown);
            alert('Waktu habis! Jawaban otomatis dikirim.');
            form.submit();
        }
    }, 1000);
</script>
@endif

@endsection
