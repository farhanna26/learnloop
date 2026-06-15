<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita cek satu-satu, kalau belum ada langsung tambahkan
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'portfolio')) {
                $table->string('portfolio')->nullable()->after('linkedin');
            }
            if (!Schema::hasColumn('users', 'banner_x')) {
                $table->integer('banner_x')->default(50);
                $table->integer('banner_y')->default(50);
                $table->integer('photo_x')->default(50);
                $table->integer('photo_y')->default(50);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['linkedin', 'portfolio', 'banner_x', 'banner_y', 'photo_x', 'photo_y']);
        });
    }
};