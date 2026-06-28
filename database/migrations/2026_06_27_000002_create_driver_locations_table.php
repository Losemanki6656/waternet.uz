<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('accuracy')->nullable();
            $table->float('speed')->nullable();
            $table->float('heading')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_locations');
    }
};
