@extends('layouts.app')

@section('title','History '.$category->name)

@section('content')
<div class="wrapper">
<div class="card">

<a href="{{ route('guru.history') }}" class="back">← Kembali</a>

<h1 style="font-weight:800;margin-bottom:24px">
📘 {{ $category->name }}
</h1>

@if($quizzes->isEmpty())
    <p>Belum ada quiz</p>
@else
<table width="100%" cellpadding="12">
<tr>
    <th align="left">Quiz</th>
    <th>Attempt</th>
    <th>Aksi</th>
</tr>

@foreach($quizzes as $quiz)
<tr>
    <td>{{ $quiz->title }}</td>
    <td align="center">{{ $quiz->attempts_count }}</td>
    <td align="center">

        {{-- MASUK PAKAI TOKEN --}}
        <form action="{{ route('guru.history.show',$category->id) }}" method="POST" style="display:inline">
            @csrf
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            <input type="password" name="token" placeholder="Token" required>
            <button class="play">Buka</button>
        </form>

        {{-- HAPUS --}}
        <form action="{{ route('guru.history.delete',$quiz->id) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="play" style="background:#ef4444">Hapus</button>
        </form>

    </td>
</tr>
@endforeach
</table>
@endif

</div>
</div>
@endsection
