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
        Schema::create('solar_recomendation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('message')->nullable();
            $table->unsignedBigInteger('umkm_id');
            $table->timestamps();

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
        Schema::dropIfExists('solar_recomendation_requests');
    }
};
