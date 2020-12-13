<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('name', 63);
            $table->string('email', 63)->unique();
            $table->string('password', 63);
            $table->date('birthDate')->nullable();
            $table->string('gender', 15)->nullable();
            $table->string('phone', 63)->nullable();
            $table->string('address', 63)->nullable();
            $table->string('role', 63)->default('farmer');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
