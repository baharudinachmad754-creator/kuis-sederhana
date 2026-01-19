<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua user demo dulu (opsional)
        // User::truncate(); // hati-hati di production

        // Buat 5 akun guru khusus
        $gurus = [
            ['name' => 'Guru 1', 'email' => 'guru1@quiz.test'],
            ['name' => 'Guru 2', 'email' => 'guru2@quiz.test'],
            ['name' => 'Guru 3', 'email' => 'guru3@quiz.test'],
            ['name' => 'Guru 4', 'email' => 'guru4@quiz.test'],
            ['name' => 'Guru 5', 'email' => 'guru5@quiz.test'],
        ];

        foreach ($gurus as $g) {
            User::updateOrCreate(
                ['email' => $g['email']],
                [
                    'name' => $g['name'],
                    'password' => Hash::make('password'), // semua password = "password"
                    'role' => 'guru',
                ]
            );
        }

        // (Opsional) buat 1 contoh siswa
        User::updateOrCreate(
            ['email' => 'siswa1@quiz.test'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );
    }
}
