<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class InspectionsController extends Controller
{
     public function showDataFromJson()
    {
    $data = file_get_contents("https://deskplan.lv/muita/app.json");
    $jsonData = json_decode($data, true);

    return view('/', ['jsonData' => $jsonData]);
    }

        public function updateUsersFromJson($jsonData)
    {
        foreach ($jsonData['inspections'] as $inspections) {
            \App\Models\Inspections::updateOrCreate(
                ['id' => $inspections['id']],
                [
                    'case_id' => $inspections['case_id'],
                    'name' => $inspections['name'],
                    'requested_by' => $inspections['requested_by'],
                    'start_ts' => $inspections['start_ts'],
                    'location' => $inspections['location'],
                    'checks' => $inspections['checks'],
                ]
            );
        }
    }
}
