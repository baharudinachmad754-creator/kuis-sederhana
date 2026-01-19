<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tidak ada user.role = 'admin' sebelum menjalankan
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('guru','siswa') NOT NULL DEFAULT 'siswa'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin','guru','siswa') NOT NULL DEFAULT 'siswa'");
    }
};
