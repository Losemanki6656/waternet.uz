<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms', function (Blueprint $table) {
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

            $table->BigInteger('client_id')->nullable()->unsigned()->change();
            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->boolean('type')->default(0)->after('sms_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms', function (Blueprint $table) {
            //
        });
    }
}