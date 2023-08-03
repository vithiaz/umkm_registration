<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('umkm_images', function (Blueprint $table) {
           $table->foreign('umkm_id')->references('id')->on('umkm')->change()->onDelete('cascade')->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('umkm_images', function (Blueprint $table) {
            $table->dropForeign('umkm_id');
        });
    }
};
