<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activation_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->change()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('activation_logs', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
};
