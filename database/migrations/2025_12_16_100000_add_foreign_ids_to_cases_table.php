<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            if (!Schema::hasColumn('cases', 'vehicle_id')) {
                // Minimal change: add a string vehicle_id column to match your models/json
                $table->string('vehicle_id')->nullable()->after('destination_country');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            if (Schema::hasColumn('cases', 'vehicle_id')) {
                try {
                    $table->dropColumn('vehicle_id');
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        });
    }
};
