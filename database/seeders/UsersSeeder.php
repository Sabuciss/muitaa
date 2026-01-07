<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $url = env('REMOTE_JSON_URL', 'https://deskplan.lv/muita/app.json');
        $this->command->info('Seeding users from: ' . $url);

        $data = @file_get_contents($url);
        if (!$data) {
            $this->command->error('Failed to fetch remote JSON for users.');
            return;
        }

        $json = json_decode($data, true);
        $items = $json['users'] ?? [];
        $count = 0;
        foreach ($items as $item) {
            if (!isset($item['id'])) continue;
            $attrs = $item;
            $attrs['id'] = (string) $item['id'];
            DB::table('users')->updateOrInsert(['id' => $attrs['id']], $attrs);
            $count++;
        }
        $this->command->info("Users seeded: {$count}");

        // Ensure primary system users exist (password = username, email = username@gmail.com)
        $main = [
            ['id' => 'admin', 'username' => 'admin', 'full_name' => 'Admin', 'name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'role' => 'admin', 'active' => true, 'email_verified_at' => now()],
            ['id' => 'inspector', 'username' => 'inspector', 'full_name' => 'Inspector', 'name' => 'Inspector', 'email' => 'inspector@gmail.com', 'password' => Hash::make('inspector'), 'role' => 'inspector', 'active' => true, 'email_verified_at' => now()],
            ['id' => 'analyst', 'username' => 'analyst', 'full_name' => 'Analyst', 'name' => 'Analyst', 'email' => 'analyst@gmail.com', 'password' => Hash::make('analyst'), 'role' => 'analyst', 'active' => true, 'email_verified_at' => now()],
            ['id' => 'broker', 'username' => 'broker', 'full_name' => 'Broker', 'name' => 'Broker', 'email' => 'broker@gmail.com', 'password' => Hash::make('broker'), 'role' => 'broker', 'active' => true, 'email_verified_at' => now()],
        ];

        foreach ($main as $m) {
            DB::table('users')->updateOrInsert(['id' => $m['id']], $m);
        }
    }
}
