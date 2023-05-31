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
        Schema::table('bank_infos', function (Blueprint $table) {
            
            $table->mediumText('fullnameArabic')->nullable();
            $table->string('counrty')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_infos', function (Blueprint $table) {
            //
        });
    }
};
