<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom sosmed jika belum ada
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'portfolio')) {
                $table->string('portfolio')->nullable()->after('linkedin');
            }
            
            // Menambahkan kolom koordinat gambar jika belum ada
            if (!Schema::hasColumn('users', 'banner_x')) {
                $table->integer('banner_x')->default(50);
                $table->integer('banner_y')->default(50);
                $table->integer('photo_x')->default(50);
                $table->integer('photo_y')->default(50);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['linkedin', 'portfolio', 'banner_x', 'banner_y', 'photo_x', 'photo_y']);
        });
    }
};