<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('support_program_members', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('support_programs')->change()->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('umkm_id')->references('id')->on('umkm')->change()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign('program_id');
        $table->dropForeign('umkm_id');
    }
};
