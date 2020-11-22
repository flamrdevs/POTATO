<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWateringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waterings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('farming_id')->unsigned();
            $table->foreign('farming_id')->references('id')->on('farmings');

            $table->timestamp('start')->useCurrent();
            $table->timestamp('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waterings');
    }
}
