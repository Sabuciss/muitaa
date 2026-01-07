<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasesSeeder extends Seeder
{
    public function run(): void
    {
        $url = env('REMOTE_JSON_URL', 'https://deskplan.lv/muita/app.json');
        $this->command->info('Seeding cases from: ' . $url);

        $data = @file_get_contents($url);
        if (!$data) {
            $this->command->error('Failed to fetch remote JSON for cases.');
            return;
        }

        $json = json_decode($data, true);
        $items = $json['cases'] ?? [];
        $count = 0;
        foreach ($items as $item) {
            if (!isset($item['id'])) continue;
            $attrs = $item;
            $attrs['id'] = (string) $item['id'];
            if (isset($attrs['risk_flags']) && is_array($attrs['risk_flags'])) {
                $attrs['risk_flags'] = json_encode($attrs['risk_flags']);
            }
            DB::table('cases')->updateOrInsert(['id' => $attrs['id']], $attrs);
            $count++;
        }
        $this->command->info("Cases seeded: {$count}");
    }
}
