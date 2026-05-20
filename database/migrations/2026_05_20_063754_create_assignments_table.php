<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            // Sambungin ke tabel rooms (ruang kelasnya)
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable(); // Buat file modul/soal dari Creator
            $table->dateTime('deadline'); // Kunci utamanya di sini: Tenggat Waktu!
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};