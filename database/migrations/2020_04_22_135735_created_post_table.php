<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_post', function (Blueprint $table) {
            $table->bigIncrements('id'); //id do post
            $table->integer('id_user'); //id do usuario que fez o post
            $table->string('post_image'); //id da imagem do post
            $table->string('post_text'); //id do texto do post
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
        Schema::dropIfExists('users_post');
    }
}
