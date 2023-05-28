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
        Schema::create('mail_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->mediumText('title');
            $table->text('message');
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
        Schema::dropIfExists('mail_messages');
    }
};
