<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Paksa MySQL buat nambahin 'classroom' ke dalem daftar ENUM
        DB::statement("ALTER TABLE rooms MODIFY type ENUM('private', 'group', 'classroom') NOT NULL DEFAULT 'group'");
    }

    public function down(): void
    {
        // Balikin ke semula kalau di-rollback
        DB::statement("ALTER TABLE rooms MODIFY type ENUM('private', 'group') NOT NULL DEFAULT 'group'");
    }
};