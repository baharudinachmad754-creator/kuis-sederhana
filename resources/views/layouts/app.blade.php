<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','Quiz App')</title>

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

html, body {
    height: 100%;
    font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont,
                 "Segoe UI", Roboto, sans-serif;
}

/* ======================================================================
   BACKGROUND — SAME AS LOGIN
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
   NAVBAR
====================================================================== */
.nav {
    position: relative;
    z-index: 10;
    background: rgba(255,255,255,.7);
    backdrop-filter: blur(16px);
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}

.nav-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.brand {
    font-weight: 900;
    font-size: 20px;
    text-decoration: none;
    color: #4f46e5;
}

.nav a.btn,
.nav button.btn {
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    margin-left: 6px;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(99,102,241,.45);
}

.nav form {
    display: inline;
}

/* ======================================================================
   MAIN CONTENT
====================================================================== */
main {
    position: relative;
    z-index: 5;
    min-height: calc(100vh - 140px);
    padding: 40px 20px;
}

/* ======================================================================
   FOOTER
====================================================================== */
.footer {
    position: relative;
    z-index: 5;
    text-align: center;
    font-size: 13px;
    color: #475569;
    padding: 18px;
}
</style>
</head>

<body>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<nav class="nav">
    <div class="nav-inner">
        <a href="{{ url('/') }}" class="brand">QuizApp</a>
        @auth
    @if(auth()->user()->role === 'guru')
        <a href="{{ route('guru.quizzes.index') }}" class="btn">
            📘 Quiz Saya
        </a>

        <a href="{{ route('guru.history.index') }}"
   class="btn {{ request()->routeIs('guru.history.*') ? 'active' : '' }}">
   📊 History Quiz
</a>


    @endif
@endauth

        <div>
            @auth
                @if(auth()->user()->role === 'siswa')
                    <a href="{{ route('siswa.history') }}" class="btn">History</a>
                    <a href="{{ route('siswa.dashboard') }}" class="btn">Quiz</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="footer">
    &copy; {{ date('Y') }} QuizApp — Fun Learning Experience
</footer>

</body>
</html>
