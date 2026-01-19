@extends('layouts.app')

@section('content')

<style>
/* ================= RESET ================= */
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* ================= BACKGROUND ================= */
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

/* ================= WRAPPER ================= */
.wrapper {
    position: relative;
    z-index: 5;
    min-height: 100vh;
    padding: 50px 24px;
    display: flex;
    justify-content: center;
}

/* ================= CARD ================= */
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

/* ================= HEADER ================= */
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

/* ================= FORM ================= */
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
textarea,
select {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
    background: rgba(255,255,255,.9);
}

input:focus,
textarea:focus,
select:focus {
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
    text-transform: uppercase;
    color: #6366f1;
}

/* ================= BUTTON ================= */
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
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* tambah soal */
.btn-primary {
    background: linear-gradient(135deg,#6366f1,#22d3ee);
    box-shadow: 0 16px 36px rgba(99,102,241,.45);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 22px 44px rgba(99,102,241,.6);
}

/* publish */
.btn-publish {
    background: linear-gradient(135deg,#16a34a,#4ade80);
    box-shadow: 0 16px 36px rgba(22,163,74,.45);
}

.btn-publish:hover {
    transform: translateY(-3px);
    box-shadow: 0 22px 44px rgba(22,163,74,.6);
}

/* link */
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
            <h1>Tambah Soal</h1>
            <p>{{ $quiz->title }} • Soal ke-{{ $questionNumber }}</p>
        </div>

        <form method="POST"
              action="{{ route('guru.quizzes.questions.store', $quiz->id) }}"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Soal</label>
                <textarea name="question_text" rows="4" required>{{ old('question_text') }}</textarea>
            </div>

            <div class="form-group">
                <label>Gambar (opsional)</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                <img id="preview" style="display:none;margin-top:10px;max-height:240px;border-radius:14px">
            </div>

            @foreach(['a','b','c','d','e'] as $k)
                <div class="form-group choice">
                    <div class="choice-key">{{ $k }}</div>
                    <input type="text"
                           name="choices[{{ $loop->index }}]"
                           value="{{ old('choices.'.$loop->index) }}"
                           placeholder="Teks pilihan {{ $k }}"
                           @if($k !== 'e') required @endif>
                </div>
            @endforeach

            <div class="form-group">
                <label>Jawaban Benar</label>
                <select name="correct_index" required style="width:140px">
                    @foreach(['a','b','c','d','e'] as $k)
                        <option value="{{ $loop->index }}"
                            {{ old('correct_index') == $loop->index ? 'selected' : '' }}>
                            {{ strtoupper($k) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="actions">
                <button type="submit" name="add_more" value="1" class="btn btn-primary">
                    ➕ Tambah & Lanjutkan
                </button>

                <button type="submit" class="btn btn-publish">
                    🚀 Selesai & Publish
                </button>

                <a href="{{ route('guru.quizzes.edit', $quiz->id) }}" class="link">Batal</a>
            </div>
        </form>

    </div>
</div>

<script>
function previewImage(e){
    const img = document.getElementById('preview');
    if(e.target.files && e.target.files[0]){
        img.src = URL.createObjectURL(e.target.files[0]);
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }
}
</script>

@endsection
