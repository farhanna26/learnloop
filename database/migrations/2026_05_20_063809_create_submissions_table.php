<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            // Sambungin ke tugas mana dan siapa yang ngumpul
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path'); // File jawaban dari Learner
            // Status bakal otomatis kita hitung di Controller nanti (Telat/Tepat Waktu)
            $table->enum('status', ['ontime', 'late'])->default('ontime');
            $table->integer('grade')->nullable(); // Kolom nilai (opsional buat pengembangan ntar)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};