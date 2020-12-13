<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationFarmingsSoilmoistures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soil_moistures', function (Blueprint $table) {
            $table->integer('farming_id')->unsigned();
            $table->foreign('farming_id')->references('id')->on('farmings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soil_moistures', function (Blueprint $table) {
            $table->dropForeign('soil_moistures_farming_id_foreign');
        });
    }
}
