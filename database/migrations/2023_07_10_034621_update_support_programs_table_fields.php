<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('support_programs', function (Blueprint $table) {
            $table->string('program_type');            
            $table->integer('quota')->nullable();
            $table->date('open_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('support_programs', function (Blueprint $table) {
            $table->dropColumn('program_type');
            $table->dropColumn('quota');
            $table->dropColumn('open_date');
            $table->dropColumn('end_date');
        });

    }
};
