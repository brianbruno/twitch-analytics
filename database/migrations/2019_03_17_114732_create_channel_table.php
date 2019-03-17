<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('_id')->unsigned()->nullable();
            $table->string('display_name', 100)->nullable();
            $table->boolean('mature')->default(false);
            $table->string('status', 255)->nullable();
            $table->string('broadcaster_language', 10)->nullable();
            $table->bigInteger('id_game')->nullable()->unsigned();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('views')->nullable();
            $table->integer('followers')->nullable();
            $table->bigInteger('id_run')->unsigned();
            $table->timestamps();

            $table->foreign('id_run')->references('id')->on('data_runs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_channels');
    }
}
