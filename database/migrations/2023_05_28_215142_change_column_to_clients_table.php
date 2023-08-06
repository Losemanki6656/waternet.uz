<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->BigInteger('organization_id')->nullable()->unsigned()->change();
            $table->index('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');

            $table->BigInteger('user_id')->nullable()->unsigned()->change();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->BigInteger('city_id')->nullable()->unsigned()->change();
            $table->index('city_id');
            $table->foreign('city_id')->references('id')->on('sities');

            $table->BigInteger('area_id')->nullable()->unsigned()->change();
            $table->index('area_id');
            $table->foreign('area_id')->references('id')->on('areas');

            $table->integer('balance')->default(0)->change();

            $table->boolean('status')->default(true)->after('activated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }
}