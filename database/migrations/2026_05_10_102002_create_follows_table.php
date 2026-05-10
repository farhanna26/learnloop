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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // ID orang yang ngeklik tombol follow (Misal: Lu)
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            
            // ID orang yang di-follow (Misal: Dihan)
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();

            // Biar nggak bisa nge-follow orang yang sama berkali-kali sampe database jebol
            $table->unique(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
