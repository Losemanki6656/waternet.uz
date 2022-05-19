<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSwipersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_swipers', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->string('name');
            $table->string('lg_name');
            $table->string('photo');
            $table->string('phone');
            $table->string('price');
            $table->text('comment');
            $table->text('photo_url');
            $table->string('other');
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
        Schema::dropIfExists('organization_swipers');
    }
}
