<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Quiz</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
   BACKGROUND — FUN BUT REALISTIC
====================================================================== */
.bg {
    position: fixed;
    inset: 0;
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
    position: absolute;
    border-radius: 50%;
    opacity: 0.45;
    filter: blur(20px);
    animation: float 14s infinite ease-in-out;
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
    top: 60%;
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
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-30px) translateX(20px); }
    100% { transform: translateY(0) translateX(0); }
}

/* ======================================================================
   CENTER WRAPPER
====================================================================== */
.wrapper {
    position: relative;
    z-index: 5;
    height: 100%;
    display: grid;
    place-items: center;
    padding: 20px;
}

/* ======================================================================
   LOGIN CARD
====================================================================== */
.card {
    width: 100%;
    max-width: 420px;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(18px);
    border-radius: 24px;
    padding: 40px 36px 34px;
    box-shadow:
        0 30px 60px rgba(0,0,0,0.12),
        inset 0 1px 0 rgba(255,255,255,0.6);
    animation: pop 0.8s ease;
}

@keyframes pop {
    from { opacity: 0; transform: scale(0.95) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* ======================================================================
   HEADER
====================================================================== */
.header {
    text-align: center;
    margin-bottom: 26px;
}

.logo {
    width: 54px;
    height: 54px;
    margin: 0 auto 12px;
    border-radius: 16px;
    background:
        linear-gradient(135deg, #6366f1, #22d3ee);
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
form {
    width: 100%;
}

.group {
    margin-bottom: 18px;
}

.group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}

.group input {
    width: 100%;
    height: 46px;
    border-radius: 14px;
    border: 1px solid #c7d2fe;
    padding: 0 16px;
    font-size: 15px;
    background: rgba(255,255,255,0.9);
    transition: all 0.2s ease;
}

.group input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.18);
}

/* ======================================================================
   OPTIONS
====================================================================== */
.options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 16px 0 24px;
    font-size: 13px;
}

.options label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #334155;
}

.options input {
    accent-color: #6366f1;
}

.options a {
    text-decoration: none;
    color: #6366f1;
    font-weight: 600;
}

.options a:hover {
    text-decoration: underline;
}

/* ======================================================================
   BUTTON
====================================================================== */
button {
    width: 100%;
    height: 48px;
    border-radius: 16px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    color: white;
    background:
        linear-gradient(135deg, #6366f1, #22d3ee);
    box-shadow:
        0 18px 36px rgba(99,102,241,0.5);
    transition: all .2s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow:
        0 24px 44px rgba(99,102,241,0.6);
}

button:active {
    transform: translateY(0);
}

/* ======================================================================
   FOOTER
====================================================================== */
.footer {
    margin-top: 20px;
    text-align: center;
    font-size: 13px;
    color: #475569;
}

.footer a {
    color: #6366f1;
    font-weight: 700;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

/* ======================================================================
   RESPONSIVE
====================================================================== */
@media (max-width: 480px) {
    .card {
        padding: 32px 24px;
    }
}
</style>
</head>

<body>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
    <div class="card">

        <div class="header">
            <div class="logo">Q</div>
            <h1>Quiz Time 🎉</h1>
            <p>Siap belajar & uji kemampuanmu?</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="group">
                <label>Email</label>
                <input type="email" name="email" required autofocus>
            </div>

            <div class="group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="options">
                <label>
                    <input type="checkbox" name="remember">
                    Remember Me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <button type="submit">Mulai Quiz 🚀</button>
        </form>

        <div class="footer">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar</a>
        </div>

    </div>
</div>

<script>
/* ======================================================================
   MICRO INTERACTION JS
====================================================================== */
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'scale(1.02)';
    });
    input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'scale(1)';
    });
});
</script>

</body>
</html>
