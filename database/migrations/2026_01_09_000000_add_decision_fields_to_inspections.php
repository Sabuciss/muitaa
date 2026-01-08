<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->string('decision')->nullable();
            $table->text('comments')->nullable();
            $table->text('justifications')->nullable();
            $table->timestamp('end_ts')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropColumn(['decision', 'comments', 'justifications', 'end_ts']);
        });
    }
};
