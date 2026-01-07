<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartiesSeeder extends Seeder
{
    public function run(): void
    {
        $url = env('REMOTE_JSON_URL', 'https://deskplan.lv/muita/app.json');
        $this->command->info('Seeding parties from: ' . $url);

        $data = @file_get_contents($url);
        if (!$data) {
            $this->command->error('Failed to fetch remote JSON for parties.');
            return;
        }

        $json = json_decode($data, true);
        $items = $json['parties'] ?? [];
        $count = 0;
        foreach ($items as $item) {
            if (!isset($item['id'])) continue;
            $attrs = $item;
            $attrs['id'] = (string) $item['id'];
            DB::table('parties')->updateOrInsert(['id' => $attrs['id']], $attrs);
            $count++;
        }
        $this->command->info("Parties seeded: {$count}");
    }
}
