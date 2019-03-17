<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_topgames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_name')->unsigned();
            $table->integer('viewers');
            $table->bigInteger('id_locale')->unsigned();
            $table->bigInteger('id_run')->unsigned();
            $table->timestamps();

            $table->foreign('id_run')->references('id')->on('data_runs');
            $table->foreign('id_name')->references('id')->on('data_labels');
            $table->foreign('id_locale')->references('id')->on('data_labels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_topgames');
    }
}
