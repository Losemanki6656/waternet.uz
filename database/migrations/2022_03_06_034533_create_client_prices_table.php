<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('success_order_id');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('payment');
            $table->integer('amount');
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
        Schema::dropIfExists('client_prices');
    }
}
