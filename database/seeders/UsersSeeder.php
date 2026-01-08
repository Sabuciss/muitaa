<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $demoUsers = [
            ['username' => 'admin', 'role' => 'admin'],
            ['username' => 'broker', 'role' => 'broker'],
            ['username' => 'inspector', 'role' => 'inspector'],
            ['username' => 'analyst', 'role' => 'analyst'],
        ];

        foreach ($demoUsers as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'api_id' => 'demo-' . $user['username'],
                    'username' => $user['username'],
                    'full_name' => ucfirst($user['username']) . ' User',
                    'password' => Hash::make($user['username']),
                    'role' => $user['role'],
                    'active' => true,
                ]
            );
        }

        $data = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();
        $items = $data['users'] ?? [];

        $roleMap = [
            'inspector' => 'inspector',
            'analyst' => 'analyst',
            'broker' => 'broker',
            'admin' => 'admin',
        ];

        foreach ($items as $item) {
            $api_id = (string)($item['id'] ?? '');
            if ($api_id === '') { continue; }

            $username = $item['username'] ?? $api_id;
            $plainPassword = $username;

            $role = $item['role'] ?? 'broker';
            if (isset($roleMap[$role])) {
                $role = $roleMap[$role];
            } else {
                $role = 'broker';
            }

            User::updateOrCreate(
                ['api_id' => $api_id],
                [
                    'api_id' => $api_id,
                    'username' => $username,
                    'full_name' => $item['full_name'] ?? $username,
                    'password' => Hash::make($plainPassword),
                    'role' => $role,
                    'active' => (bool)($item['active'] ?? true),
                ]
            );
        }
    }
}
