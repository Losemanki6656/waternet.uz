<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('director_name');
            $table->string('location');
            $table->integer('traffic_id');
            $table->integer('balance');
            $table->integer('clients_count');
            $table->integer('sms_count');
            $table->integer('products_count');
            $table->integer('users_count');
            $table->date('date_traffic');
            $table->string('phone');
            $table->text('comment');
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
        Schema::dropIfExists('organizations');
    }
}
