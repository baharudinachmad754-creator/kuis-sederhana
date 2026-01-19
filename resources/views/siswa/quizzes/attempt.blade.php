@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:20px auto;padding:18px">

  <h2 style="font-size:22px;font-weight:700;color:#4F46E5;margin-bottom:16px">
    {{ $quiz->title }}
  </h2>

  <form method="POST" action="{{ route('siswa.quiz.submit', $quiz->id) }}">
    @csrf

    @foreach ($quiz->questions as $q)
      <div style="border:1px solid #E5E7EB;border-radius:12px;padding:16px;margin-bottom:18px">

        {{-- TEKS SOAL --}}
        <p style="font-weight:600;margin-bottom:8px">
          {{ $loop->iteration }}. {{ $q->question_text }}
        </p>

        {{-- 🔥 GAMBAR SOAL (INI YANG HILANG SELAMA INI) --}}
        @if ($q->image)
          <img
            src="{{ asset('storage/'.$q->image) }}"
            style="max-width:100%;margin:12px 0;border-radius:10px"
            alt="gambar soal"
          >
        @endif

        {{-- PILIHAN JAWABAN --}}
        <div style="margin-top:10px">
          @foreach ($q->choices as $c)
            <label style="display:block;margin-bottom:6px;cursor:pointer">
              <input
                type="radio"
                name="answers[{{ $q->id }}]"
                value="{{ $c->label }}"
                required
              >
              {{ $c->label }}. {{ $c->choice_text }}
            </label>
          @endforeach
        </div>

      </div>
    @endforeach

    <button type="submit"
      style="background:#4F46E5;color:#fff;padding:10px 16px;border-radius:10px;border:none">
      Kirim Jawaban
    </button>

  </form>
</div>
@endsection
