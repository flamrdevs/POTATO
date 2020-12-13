<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationFarmingsWaterings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waterings', function (Blueprint $table) {
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
        Schema::table('waterings', function (Blueprint $table) {
            $table->dropForeign('waterings_farming_id_foreign');
        });
    }
}
