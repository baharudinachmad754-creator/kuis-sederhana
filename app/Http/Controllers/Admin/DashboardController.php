<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function students() {
        // TODO: ambil data siswa + hasil quiz
        return view('admin.students.index');
    }
}
