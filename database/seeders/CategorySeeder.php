<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'Bahasa Inggris',
            'Bahasa Indonesia',
            'Kalkulus 3',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name
            ]);
        }
    }
}
