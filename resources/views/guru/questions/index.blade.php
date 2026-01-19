@extends('layouts.app')

@section('title','Soal Saya')

@section('content')
<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
    <div>
      <h3 style="font-size:18px;font-weight:700;color:#4F46E5">Daftar Soal Saya</h3>
      <p class="muted">Kelola soal yang kamu buat</p>
    </div>
    <div>
      <a href="{{ route('guru.questions.create') }}" class="btn">Buat Soal Baru</a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin-bottom:12px;padding:10px;border-radius:8px;background:#ECFDF5;color:#065F46">
      {{ session('success') }}
    </div>
  @endif

  @if($questions->count())
    <table style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="text-align:left;color:#6B7280;font-size:13px">
          <th style="padding:8px 6px">ID</th>
          <th style="padding:8px 6px">Kategori</th>
          <th style="padding:8px 6px">Soal</th>
          <th style="padding:8px 6px">Difficulty</th>
          <th style="padding:8px 6px">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @foreach($questions as $q)
        <tr>
          <td style="padding:10px 6px;border-top:1px solid #f3f4f6">{{ $q->id }}</td>
          <td style="padding:10px 6px;border-top:1px solid #f3f4f6">{{ $q->category->name ?? '-' }}</td>
          <td style="padding:10px 6px;border-top:1px solid #f3f4f6">{{ \Illuminate\Support\Str::limit($q->question_text, 80) }}</td>
          <td style="padding:10px 6px;border-top:1px solid #f3f4f6">{{ $q->difficulty }}</td>
          <td style="padding:10px 6px;border-top:1px solid #f3f4f6">
            <a href="{{ route('guru.questions.show', $q->id) }}" class="link" style="margin-right:8px">Lihat</a>
            <a href="{{ route('guru.questions.edit', $q->id) }}" class="link" style="margin-right:8px">Edit</a>
            <form action="{{ route('guru.questions.destroy', $q->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus soal ini?')">
              @csrf @method('DELETE')
              <button type="submit" style="background:#EF4444;color:#fff;padding:6px 8px;border-radius:8px;border:none;cursor:pointer">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <div style="margin-top:14px">
      {{ $questions->links() }}
    </div>
  @else
    <p class="muted">Belum ada soal. Buat soal pertama kamu sekarang.</p>
  @endif
</div>
@endsection
