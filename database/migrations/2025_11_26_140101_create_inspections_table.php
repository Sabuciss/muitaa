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
        Schema::create('inspections', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('case_id');
            $table->string('type')->nullable();
            $table->string('requested_by')->nullable();
            $table->datetime('start_ts')->nullable();
            $table->string('location')->nullable();
            $table->json('checks')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('risk_level')->nullable();
            $table->string('risk_flag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
