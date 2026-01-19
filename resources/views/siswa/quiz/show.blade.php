@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:20px auto;padding:18px">

  <h2 style="font-size:20px;font-weight:700;color:#4F46E5;margin-bottom:8px">
    {{ $quiz->title }}
  </h2>

  <p style="color:#6B7280">{{ $quiz->description }}</p>

  {{-- JUMLAH SOAL REAL --}}
  <p style="color:#6B7280">
    Soal: {{ $quiz->questions->count() }}
  </p>

  {{-- PREVIEW SOAL (BIAR SISWA & GURU SAMA) --}}
  <div style="margin-top:20px">
    @foreach ($quiz->questions as $q)
      <div style="border:1px solid #E5E7EB;border-radius:10px;padding:14px;margin-bottom:14px">

        <p style="font-weight:600">{{ $loop->iteration }}. {{ $q->question_text }}</p>

        {{-- GAMBAR --}}
        @if($q->image)
          <img
            src="{{ asset('storage/'.$q->image) }}"
            style="max-width:100%;margin:12px 0;border-radius:10px"
          >
        @endif

        {{-- PILIHAN --}}
        <ul style="margin-top:8px">
          @foreach($q->choices as $c)
            <li style="color:#374151">
              {{ $c->label }}. {{ $c->choice_text }}
            </li>
          @endforeach
        </ul>

      </div>
    @endforeach
  </div>

  <div style="margin-top:12px">
    <a href="#" class="btn"
       style="background:#4F46E5;color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none">
       Mulai Quiz (TODO)
    </a>

    <a href="{{ route('siswa.quiz.index') }}"
       style="margin-left:8px"
       class="link">
       Kembali
    </a>
  </div>

</div>
@endsection
