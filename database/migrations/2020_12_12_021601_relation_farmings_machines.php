<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationFarmingsMachines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->string('machine_code', 63)->nullable();
            $table->foreign('machine_code')->references('code')->on('machines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->dropForeign('farmings_machine_code_foreign');
        });
    }
}
