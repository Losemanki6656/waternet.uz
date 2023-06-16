<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('organization_id')->unsigned()->index()->nullable()->after('id');
            $table->integer('role')->nullable()->after('organization_id');
            $table->text('mobile_token')->nullable()->after('remember_token');
            $table->string('areas')->nullable()->after('mobile_token');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("organization_id");
            $table->dropColumn("role");
            $table->dropColumn("mobile_token");
            $table->dropColumn("areas");
        });
    }
}