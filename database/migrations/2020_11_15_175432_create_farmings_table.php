<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmings', function (Blueprint $table) {
            $table->increments('id');
            // $table->dateTime('start')->default(new DateTime());
            // $table->dateTime('end')->nullable();
            // $table->foreign('machine_id')->references('machine_id')->on('soilmoistures');
            // $table->foreign('plant_id')->references('id')->on('plants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmings');
    }
}
