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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('description');
            $table->mediumText('small_description')->nullable();
            $table->text('meta_title');
            $table->unsignedBigInteger('image_id');
            $table->mediumText('slug')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('publish_time')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('user_id')->references('id')->on('admins')->onCascade('delete');
            $table->foreign('image_id')->references('id')->on('blog_images')->onCascade('delete');

            
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
        Schema::dropIfExists('blogs');
    }
};
