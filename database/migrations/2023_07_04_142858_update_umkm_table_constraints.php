<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->foreign('owner_user')->references('id')->on('users')->change()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
};
