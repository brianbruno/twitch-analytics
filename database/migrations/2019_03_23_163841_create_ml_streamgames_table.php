<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMlStreamgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_streamgames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_game')->unsigned();
            $table->bigInteger('id_channel')->unsigned();
            $table->integer('id_weekday')->nullable();
            $table->integer('id_hour');
            $table->integer('viewers');
            $table->timestamps();

            $table->foreign('id_game')->references('id')->on('data_labels');
            $table->foreign('id_channel')->references('id')->on('data_channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ml_streamgames');
    }
}
