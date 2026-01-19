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
    max-width:1100px;
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:16px;
}
.header-left{
    display:flex;
    align-items:center;
    gap:14px;
}
.logo{
    width:52px;
    height:52px;
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
}

/* ======================================================================
   BUTTON
====================================================================== */
.btn{
    padding:10px 18px;
    border-radius:999px;
    font-weight:700;
    font-size:14px;
    color:#fff;
    text-decoration:none;
    background:linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow:0 14px 30px rgba(99,102,241,.45);
}
.btn:hover{transform:translateY(-2px)}

/* ======================================================================
   LIST
====================================================================== */
.quiz{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 22px;
    border-radius:18px;
    background:rgba(255,255,255,.88);
    border:1px solid #e0e7ff;
    margin-bottom:14px;
    box-shadow:0 10px 26px rgba(99,102,241,.12);
}
.quiz-title{
    font-weight:800;
    color:#1e293b;
}
.quiz-meta{
    font-size:13px;
    color:#64748b;
    margin-top:4px;
}
.quiz-actions a{
    margin-right:12px;
    font-weight:700;
    color:#6366f1;
    text-decoration:none;
}
.quiz-actions button{
    background:#ef4444;
    color:#fff;
    padding:8px 14px;
    border-radius:999px;
    border:none;
    font-weight:700;
    cursor:pointer;
}

/* ======================================================================
   ALERT
====================================================================== */
.alert{
    background:#ecfdf5;
    color:#065f46;
    padding:14px 18px;
    border-radius:14px;
    margin-bottom:20px;
}

/* ======================================================================
   EMPTY
====================================================================== */
.empty{
    text-align:center;
    color:#64748b;
    font-size:14px;
    margin-top:20px;
}
</style>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
<div class="card">

    <div class="header">
        <div class="header-left">
            <div class="logo">Q</div>
            <div>
                <h1>Quiz Saya</h1>
                <p>Kelola quiz yang telah dibuat</p>
            </div>
        </div>

        <a href="{{ route('guru.quizzes.create') }}" class="btn">
            + Buat Quiz Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @forelse($quizzes as $q)
        <div class="quiz">
            <div>
                <div class="quiz-title">
                    {{ $q->title }}
                    <span style="font-weight:600;color:#64748b">
                        · {{ $q->category->name ?? '-' }}
                    </span>
                </div>
                <div class="quiz-meta">
                    Soal: {{ $q->questions_count }} · {{ $q->created_at->format('Y-m-d') }}
                </div>
            </div>

            <div class="quiz-actions">
                <a href="{{ route('guru.quizzes.edit', $q->id) }}">
                    Kelola
                </a>

                <form action="{{ route('guru.quizzes.destroy', $q->id) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Hapus quiz ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty">Belum ada quiz.</div>
    @endforelse

    <div style="margin-top:20px">
        {{ $quizzes->links() }}
    </div>

</div>
</div>

@endsection
