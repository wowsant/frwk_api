<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_image_storage', 255)->nullable();
            $table->string('mime_type', 50)->nullable();
            $table->string('name_original', 255)->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('album_id');
            $table->string('name', 100)->nullable();
            $table->string('label');
            $table->timestamps();
        });
        // Schema::create('photos', function (Blueprint $table) {
        //     $table->foreign('album_id')->references('id')->on('albums');
        //     $table->foreign('user_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
