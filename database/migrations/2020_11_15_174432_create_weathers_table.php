<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idArea', 15);

            $table->string('attributes', 2047);
            $table->string('humidity', 2047);
            $table->string('minHumidity', 1023);
            $table->string('maxHumidity', 1023);
            $table->string('temperature', 2047);
            $table->string('minTemperature', 1023);
            $table->string('maxTemperature', 1023);
            $table->string('weather', 2047);
            
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weathers');
    }
}
