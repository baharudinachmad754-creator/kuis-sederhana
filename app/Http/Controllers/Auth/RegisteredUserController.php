<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'kelas'    => 'required|string|max:100', // 🔥 VALIDASI KELAS
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'kelas'    => $request->kelas, // 🔥 SIMPAN
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('siswa.dashboard');
    }
}
