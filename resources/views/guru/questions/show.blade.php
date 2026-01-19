@extends('layouts.app')

@section('title','Lihat Soal')

@section('content')
<div class="card">
  <h3 style="font-size:18px;font-weight:700;color:#4F46E5;margin-bottom:8px">Soal #{{ $q->id }}</h3>
  <p class="muted">Kategori: {{ $q->category->name ?? '-' }} &middot; Difficulty: {{ $q->difficulty }}</p>

  <div style="margin-top:12px;margin-bottom:12px">
    <div style="font-weight:600;margin-bottom:8px">Pertanyaan:</div>
    <div style="padding:12px;border-radius:8px;background:#f8fafc;border:1px solid #eef2ff">{{ $q->question_text }}</div>
  </div>

  <div style="margin-top:12px;">
    <div style="font-weight:600;margin-bottom:8px">Pilihan:</div>
    <ul style="padding-left:18px">
      @foreach($q->choices as $c)
        <li style="margin-bottom:6px">
          <strong style="text-transform:uppercase">{{ $c->label }}</strong>. {{ $c->choice_text }}
          @if($c->is_correct)
            <span style="background:#DCFCE7;color:#065F46;padding:2px 8px;border-radius:8px;margin-left:8px;font-size:12px">Benar</span>
          @endif
        </li>
      @endforeach
    </ul>
  </div>

  @if($q->explanation)
    <div style="margin-top:12px">
      <div style="font-weight:600;margin-bottom:6px">Pembahasan:</div>
      <div style="padding:12px;border-radius:8px;background:#fff7ed;border:1px solid #ffedd5">{{ $q->explanation }}</div>
    </div>
  @endif

  <div style="margin-top:12px">
    <a href="{{ route('guru.questions.edit', $q->id) }}" class="btn">Edit</a>
    <a href="{{ route('guru.questions.index') }}" class="link" style="margin-left:12px">Kembali</a>
  </div>
</div>
@endsection
