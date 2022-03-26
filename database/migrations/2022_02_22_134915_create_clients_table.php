<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('user_id');
            $table->integer('city_id');
            $table->integer('area_id');
            $table->string('fullname');
            $table->string('street');
            $table->string('home_number');
            $table->string('entrance');
            $table->string('floor');
            $table->string('apartment_number');
            $table->text('address');
            $table->string('location');
            $table->string('login');
            $table->string('password');
            $table->string('balance');
            $table->integer('container');
            $table->integer('bonus');
            $table->string('phone');
            $table->string('phone2');
            $table->date('activated_at');
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
        Schema::dropIfExists('clients');
    }
}
