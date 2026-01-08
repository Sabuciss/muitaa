<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('inspections')
            ->whereNull('risk_level')
            ->update(['risk_level' => 'Medium']);
    }

    public function down(): void
    {
        DB::table('inspections')
            ->where('risk_level', 'Medium')
            ->update(['risk_level' => null]);
    }
};
