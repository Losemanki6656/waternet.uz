<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('annotation');
            $table->integer('price');
            $table->integer('clients_count');
            $table->integer('sms_count');
            $table->integer('products_count');
            $table->integer('users_count');
            $table->boolean('status');
            $table->string('style1');
            $table->string('style2');
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
        Schema::dropIfExists('traffic');
    }
}
