<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('last_lat', 10, 7)->nullable()->after('areas');
            $table->decimal('last_lng', 10, 7)->nullable()->after('last_lat');
            $table->timestamp('last_location_at')->nullable()->after('last_lng');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_lat', 'last_lng', 'last_location_at']);
        });
    }
};
