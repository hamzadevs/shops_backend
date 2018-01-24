<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users_shops', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('shop_id')->unsigned();
          $table->boolean('like')->default(1);
          $table->boolean('dislike')->default(0);
          $table->datetime('dislike_date')->nullable();
          $table->timestamps();

          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('shop_id')->references('id')->on('shops');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_shops');
    }
}
