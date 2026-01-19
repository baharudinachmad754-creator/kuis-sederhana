@extends('layouts.app')

@section('title','History Quiz')

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

.shape.one { width:260px;height:260px;background:#60a5fa;top:10%;left:8%; }
.shape.two { width:220px;height:220px;background:#34d399;top:65%;left:70%;animation-delay:3s; }
.shape.three { width:180px;height:180px;background:#f472b6;top:20%;right:10%;animation-delay:6s; }

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
    max-width: 1100px;
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(18px);
    border-radius: 28px;
    padding: 42px;
    box-shadow: 0 30px 60px rgba(0,0,0,.12),
                inset 0 1px 0 rgba(255,255,255,.6);
    animation: pop .8s ease;
}

@keyframes pop {
    from { opacity:0; transform:scale(.96) translateY(20px); }
    to { opacity:1; transform:scale(1) translateY(0); }
}

/* ================= HEADER ================= */
.header {
    text-align: center;
    margin-bottom: 34px;
}

.logo {
    width:56px;height:56px;
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

.header h1 {
    font-size:28px;
    font-weight:800;
    color:#1e293b;
}

.header p {
    font-size:14px;
    color:#475569;
    margin-top:6px;
}

/* ================= TABLE ================= */
.table-wrap { overflow-x:auto; }

table {
    width:100%;
    border-collapse:collapse;
}

thead th {
    font-size:13px;
    color:#475569;
    padding:14px 16px;
    border-bottom:2px solid #e0e7ff;
}

tbody td {
    padding:14px 16px;
    font-size:14px;
    color:#1e293b;
    border-bottom:1px solid #e5e7eb;
}

tbody tr:hover {
    background:rgba(99,102,241,.06);
}

.badge-score {
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    color:#fff;
    background:linear-gradient(135deg,#6366f1,#22d3ee);
}

/* tombol hapus */
.btn-delete {
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    border:none;
    cursor:pointer;
    color:#fff;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    box-shadow:0 6px 14px rgba(239,68,68,.45);
}

.btn-delete:hover {
    opacity:.9;
}

.empty {
    text-align:center;
    padding:40px 0;
    color:#64748b;
    font-size:14px;
}
</style>

<div class="bg"></div>
<div class="shape one"></div>
<div class="shape two"></div>
<div class="shape three"></div>

<div class="wrapper">
    <div class="card">

        <div class="header">
            <div class="logo">📊</div>
            <h1>History Quiz</h1>
            <p>{{ $quiz->title }}</p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Skor</th>
                        <th>Waktu Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($attempts as $a)
                    <tr>
                        <td>{{ $a->user->name }}</td>
                        <td>{{ $a->user->kelas ?? '-' }}</td>
                        <td><span class="badge-score">{{ $a->score }}</span></td>
                        <td>{{ $a->finished_at }}</td>
                        <td>
                            <form method="POST"
                                  action="{{ route('guru.history.delete', $a->id) }}"
                                  onsubmit="return confirm('Hapus history siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada siswa yang mengerjakan quiz ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
