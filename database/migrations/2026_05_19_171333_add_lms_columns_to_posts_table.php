<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('type', ['portfolio', 'learning'])->default('portfolio')->after('content');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['type', 'category_id']);
        });
    }
};