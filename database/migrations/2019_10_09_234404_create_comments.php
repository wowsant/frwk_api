<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('post_id');
            $table->string('body', 255)->nullable();
            $table->timestamps();
        });
        // Versão do maria db estava impactando, por isso o comentario, caso eu atualize o maria db e vocês não poderia da erro na execução.
        // Schema::create('comments', function (Blueprint $table) {
        //     $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('comments');
    }
}
