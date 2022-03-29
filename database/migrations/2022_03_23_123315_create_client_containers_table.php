<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_containers', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('success_order_id');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('count');
            $table->integer('invalid_count');
            $table->string('comment');
            $table->integer('status');
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
        Schema::dropIfExists('client_containers');
    }
}
