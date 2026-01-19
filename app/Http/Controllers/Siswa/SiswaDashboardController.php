<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;

class SiswaDashboardController extends Controller
{
    /**
     * Dashboard siswa
     * Tampilkan card mapel (kategori)
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('siswa.dashboard', compact('categories'));
    }

    /**
     * Daftar quiz berdasarkan mapel
     */
    public function byCategory(Category $category)
    {
        $quizzes = Quiz::where('category_id', $category->id)
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('siswa.quizzes-by-category', compact('category', 'quizzes'));
    }
}
