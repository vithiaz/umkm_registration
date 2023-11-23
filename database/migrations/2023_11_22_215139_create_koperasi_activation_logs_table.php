<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koperasi_activation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('message');
            $table->unsignedBigInteger('koperasi_id');
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->change()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koperasi_activation_logs');
    }
};
