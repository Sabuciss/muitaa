<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Vehicles;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['vehicles'] as $vehicles) {
            Vehicles::create([
                'id' => $vehicles['id'],
                'plate_no' => $vehicles['plate_no'],
                'country' => $vehicles['country'],
                'make' => $vehicles['make'],
                'model' => $vehicles['model'],
                'vin' => $vehicles['vin'],
            ]);
        }
    }
}
