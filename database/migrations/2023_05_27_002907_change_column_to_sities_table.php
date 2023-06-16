<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToSitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sities', function (Blueprint $table) {
            $table->BigInteger('organization_id')->nullable()->unsigned()->change();
            $table->index('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');
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
        Schema::table('sities', function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }
}
