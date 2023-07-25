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
        Schema::create('discount_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->date('start_at');
            $table->date('end_at');
            $table->string("discount");
            $table->foreign('package_id')->references('id')->on('packages')->onCascade('delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_packages');
    }
};
