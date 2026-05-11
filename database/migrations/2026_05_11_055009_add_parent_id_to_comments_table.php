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
    Schema::table('comments', function (Blueprint $table) {
        // parent_id buat nandain ini balesan ke komentar mana. 
        // Nullable karena komentar utama nggak punya bapak.
        $table->unsignedBigInteger('parent_id')->nullable()->after('post_id');
        $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
