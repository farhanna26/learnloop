<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('room_user', function (Blueprint $table) {
            // Kita tambahin kolom role, defaultnya 'learner'
            $table->string('role')->default('learner')->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('room_user', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};