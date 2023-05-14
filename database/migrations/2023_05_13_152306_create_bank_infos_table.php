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
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->string('type');
            $table->string('paypal_email')->nullable();
            $table->string('fullname')->nullable();
            $table->integer('persionID')->nullable();
            $table->string('Idimage')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('ibanNumber')->nullable();
            $table->string('owner_name')->nullable();
            $table->integer('status')->default(0);
            $table->text('error_message')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
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
        Schema::dropIfExists('bank_infos');
    }
};
