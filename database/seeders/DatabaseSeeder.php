<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders that sync from remote JSON.
        $this->call([
            VehiclesSeeder::class,
            UsersSeeder::class,
            CasesSeeder::class,
            InspectionsSeeder::class,
            DocumentsSeeder::class,
            PartiesSeeder::class,
        ]);
    }
}
