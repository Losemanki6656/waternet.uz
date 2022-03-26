<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuccessOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('success_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('client_id');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->integer('order_user_id');
            $table->integer('order_status');
            $table->string('fullname');
            $table->string('phone');
            $table->text('address');
            $table->integer('order_count');
            $table->bigInteger('order_price');
            $table->integer('count');
            $table->bigInteger('price');
            $table->integer('container');
            $table->integer('invalid_container_count');
            $table->integer('payment');
            $table->bigInteger('amount');
            $table->date('order_date');
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
        Schema::dropIfExists('success_orders');
    }
}
