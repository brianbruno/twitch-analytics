<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskToDataRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_runs', function (Blueprint $table) {
            $table->string('task', 50)->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_runs', function (Blueprint $table) {
            $table->dropColumn('task');
        });
    }
}
