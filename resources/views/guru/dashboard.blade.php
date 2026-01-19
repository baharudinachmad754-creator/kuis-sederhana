@extends('layouts.app')

@section('title','Dashboard Guru')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-8 border-t-4 border-indigo-600">
  <h2 class="text-3xl font-bold text-indigo-600 mb-4">Halo, {{ auth()->user()->name }} (Guru)</h2>
  <p class="text-gray-600 mb-6">Ini adalah dashboard guru, buat dan kelola soal di sini.</p>
  <a href="{{ route('guru.questions.create') }}"
     class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">Buat Soal Baru</a>
</div>
@endsection
