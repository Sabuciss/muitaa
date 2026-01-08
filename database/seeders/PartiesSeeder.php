<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Parties;

class PartiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['parties'] as $parties) {
            Parties::create([
                'id' => $parties['id'],
                'type' => $parties['type'],
                'name' => $parties['name'],
                'reg_code' => $parties['reg_code'],
                'vat' => $parties['vat'],
                'country' => $parties['country'],
                'email' => $parties['email'],
                'phone' => $parties['phone'],
            ]);
        }
    }
}
