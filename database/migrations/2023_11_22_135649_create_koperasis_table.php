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
        Schema::create('koperasi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_number');
            $table->date('legal_date');
            $table->string('status');
            $table->text('address');
            $table->string('village');
            $table->string('sub_district');
            $table->string('city');
            $table->unsignedBigInteger('owner_user');
            $table->timestamps();

            $table->foreign('owner_user')->references('id')->on('users')->onChange('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koperasi');
    }
};
