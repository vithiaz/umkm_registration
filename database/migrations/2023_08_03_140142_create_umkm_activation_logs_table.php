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
        Schema::create('umkm_activation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('message');
            $table->unsignedBigInteger('umkm_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('umkm_activation_logs');
    }
};
