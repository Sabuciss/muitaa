<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Cases;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['cases'] as $cases) {
            Cases::create([
                'id' => $cases['id'],
                'external_ref' => $cases['external_ref'],
                'status' => $cases['status'],
                'priority' => $cases['priority'],
                'arrival_ts' => $cases['arrival_ts'],
                'checkpoint_id' => $cases['checkpoint_id'],
                'origin_country' => $cases['origin_country'],
                'destination_country' => $cases['destination_country'],
                'risk_flags' => $cases['risk_flags'],
                'declarant_id' => $cases['declarant_id'],
                'consignee_id' => $cases['consignee_id'],
                'vehicle_id' => $cases['vehicle_id'],
            ]);
        }
    }
}
