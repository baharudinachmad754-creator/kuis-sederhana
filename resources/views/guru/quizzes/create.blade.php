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
            0% {
                filter: hue-rotate(0deg);
            }

            100% {
                filter: hue-rotate(15deg);
            }
        }

        /* floating shapes */
        .shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.45;
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
            0% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, -30px);
            }

            100% {
                transform: translate(0, 0);
            }
        }

        /* ================= WRAPPER ================= */
        .wrapper {
            position: relative;
            z-index: 5;
            min-height: 100vh;
            padding: 50px 24px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* ================= CARD ================= */
        .card {
            width: 100%;
            max-width: 720px;
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(18px);
            border-radius: 28px;
            padding: 40px;
            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            animation: pop .8s ease;
        }

        @keyframes pop {
            from {
                opacity: 0;
                transform: scale(.96) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            width: 56px;
            height: 56px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: linear-gradient(135deg, #6366f1, #22d3ee);
            display: grid;
            place-items: center;
            color: white;
            font-weight: 900;
            font-size: 22px;
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.4);
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
            margin-bottom: 16px;
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
            background: rgba(255, 255, 255, 0.9);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .25);
        }

        /* ================= BUTTON ================= */
        .btn {
            margin-top: 18px;
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #22d3ee);
            box-shadow: 0 14px 30px rgba(99, 102, 241, .45);
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, .6);
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 480px) {
            .card {
                padding: 28px 22px;
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
                <h1>Buat Quiz Baru ✍️</h1>
                <p>Lengkapi data quiz sebelum menambahkan soal</p>
            </div>

            <form method="POST" action="{{ route('guru.quizzes.store') }}">
                @csrf

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Judul Quiz</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi (opsional)</label>
                    <textarea name="description" rows="3"></textarea>
                </div>

                {{-- 🔑 TOKEN QUIZ --}}
                <div class="form-group">
                    <label>Token Quiz</label>
                    <input type="text" name="token" placeholder="Contoh: MTK-2026" required>
                </div>

                {{-- ⏱️ DURASI --}}
                <div class="form-group">
                    <label>Durasi (menit)</label>
                    <input type="number" name="duration" min="1" placeholder="Contoh: 30" required>
                </div>

                <button type="submit" class="btn">
                    Simpan & Lanjut Buat Soal
                </button>
            </form>

        </div>
    </div>

@endsection