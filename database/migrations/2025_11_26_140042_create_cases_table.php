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
        Schema::create('cases', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('external_ref')->nullable();
            $table->string('status')->nullable();
            $table->string('priority')->nullable();
            $table->string('arrival_ts')->nullable();
            $table->string('checkpoint_id')->nullable();
            $table->string('origin_country')->nullable();
            $table->string('destination_country')->nullable();
            $table->string('hs_code')->nullable();
            $table->json('risk_flags')->nullable();
            $table->string('declarant_id')->nullable();
            $table->string('consignee_id')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->index('declarant_id');
            $table->index('consignee_id');
            $table->index('vehicle_id');
            $table->foreign('declarant_id')->references('id')->on('parties')->nullOnDelete();
            $table->foreign('consignee_id')->references('id')->on('parties')->nullOnDelete();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->nullOnDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
