<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InspectionsSeeder extends Seeder
{
    public function run(): void
    {
        $url = env('REMOTE_JSON_URL', 'https://deskplan.lv/muita/app.json');
        $this->command->info('Seeding inspections from: ' . $url);

        $data = @file_get_contents($url);
        if (!$data) {
            $this->command->error('Failed to fetch remote JSON for inspections.');
            return;
        }

        $json = json_decode($data, true);
        $items = $json['inspections'] ?? [];
        $count = 0;
        foreach ($items as $item) {
            if (!isset($item['id'])) continue;
            $attrs = $item;
            $attrs['id'] = (string) $item['id'];
            if (isset($attrs['checks']) && is_array($attrs['checks'])) {
                $attrs['checks'] = json_encode($attrs['checks']);
            }
            if (isset($attrs['start_ts']) && is_string($attrs['start_ts'])) {
                try {
                    $attrs['start_ts'] = Carbon::parse($attrs['start_ts'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $attrs['start_ts'] = null;
                }
            }
            DB::table('inspections')->updateOrInsert(['id' => $attrs['id']], $attrs);
            $count++;
        }
        $this->command->info("Inspections seeded: {$count}");
    }
}
