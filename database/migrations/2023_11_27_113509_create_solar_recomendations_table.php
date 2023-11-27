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
        Schema::create('solar_recomendations', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');
            $table->date('registration_date');
            $table->date('expired_date');
            $table->string('solar_recomendation_docs');
            $table->unsignedBigInteger('request_id');
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('solar_recomendation_requests')->change()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solar_recomendations');
    }
};
