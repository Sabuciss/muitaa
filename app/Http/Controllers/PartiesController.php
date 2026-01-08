<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{

    public function showDataFromJson()
    {
    $data = file_get_contents("https://deskplan.lv/muita/app.json");
    $jsonData = json_decode($data, true);

    return view('/', ['jsonData' => $jsonData]);
    }

        public function updateVehiclesFromJson($jsonData)
    {
        foreach ($jsonData['vehicles'] as $vehicle) {
            Vehicle::updateOrCreate(
                ['id' => $vehicle['id']],
                [
                    'plate_no' => $vehicle['plate_no'],
                    'country' => $vehicle['country'],
                    'make' => $vehicle['make'],
                    'model' => $vehicle['model'],
                    'vin' => $vehicle['vin'],
                ]
            );
        }
    }
}