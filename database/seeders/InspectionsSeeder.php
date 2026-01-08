<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Inspections;
use Carbon\Carbon;

class InspectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['inspections'] as $inspections) {
            $startTs = null;
            if (isset($inspections['start_ts'])) {
                try {
                    $startTs = Carbon::parse($inspections['start_ts'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $startTs = null;
                }
            }

            Inspections::create([
                'id' => $inspections['id'],
                'case_id' => $inspections['case_id'],
                'type' => $inspections['type'],
                'requested_by' => $inspections['requested_by'],
                'start_ts' => $startTs,
                'location' => $inspections['location'],
                'checks' => $inspections['checks'],
                'assigned_to' => $inspections['assigned_to'],
            ]);
        }
    }
}
