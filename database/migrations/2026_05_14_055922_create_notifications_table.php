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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang nerima notif ini? (Misal: Miss Zaychik)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Siapa pelakunya / yang ngirim? (Misal: Farhan)
            $table->foreignId('sender_id')->nullable()->constrained('users')->cascadeOnDelete();
            
            // Jenis notifnya apa? (Misal: 'follow', 'like', 'comment')
            $table->string('type');
            
            // (Opsional) ID postingan atau komentar terkait, kalau ada
            $table->unsignedBigInteger('reference_id')->nullable();
            
            // Udah dibaca apa belum? (Default: belum / false)
            $table->boolean('is_read')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};