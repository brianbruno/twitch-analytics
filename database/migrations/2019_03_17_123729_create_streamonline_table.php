<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamonlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_streamsonline', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('_id')->unsigned()->nullable();
            $table->bigInteger('id_game')->unsigned();
            $table->bigInteger('id_channel')->unsigned();
            $table->string('status', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('viewers')->nullable();
            $table->bigInteger('id_run')->unsigned();
            $table->timestamps();

            $table->foreign('id_game')->references('id')->on('data_labels');
            $table->foreign('id_channel')->references('id')->on('data_channels');
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
        Schema::dropIfExists('data_streamsonline');
    }
}
