<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->BigInteger('organization_id')->nullable()->unsigned()->change();
            $table->index('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->BigInteger('city_id')->nullable()->unsigned()->change();
            $table->index('city_id');
            $table->foreign('city_id')->references('id')->on('sities');
            $table->boolean('status')->default(true)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }
}
