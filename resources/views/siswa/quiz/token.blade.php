@extends('layouts.app')

@section('content')
<div style="max-width:420px;margin:100px auto;padding:30px;background:#fff;border-radius:20px;box-shadow:0 20px 40px rgba(0,0,0,.15)">
    <h2 style="text-align:center;margin-bottom:20px">Masukkan Token Quiz 🔐</h2>

    @error('token')
        <div style="color:red;margin-bottom:10px;text-align:center">
            {{ $message }}
        </div>
    @enderror

    <form method="POST" action="{{ route('siswa.quiz.verify-token', $quiz->id) }}">
        @csrf

        <input
            type="text"
            name="token"
            placeholder="Token dari guru"
            required
            style="width:100%;padding:12px;border-radius:10px;border:1px solid #ccc;margin-bottom:16px"
        >

        <button
            style="width:100%;padding:12px;border-radius:10px;border:none;background:#6366f1;color:#fff;font-weight:700"
        >
            Masuk Quiz
        </button>
    </form>
</div>
@endsection
