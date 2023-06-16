<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->BigInteger('organization_id')->nullable()->unsigned()->change();
            $table->index('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');

            $table->integer('price')->default(0)->change();

            $table->boolean('status')->default(true)->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }
}
