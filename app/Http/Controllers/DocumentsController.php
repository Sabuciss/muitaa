<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
     public function showDataFromJson()
    {
    $data = file_get_contents("https://deskplan.lv/muita/app.json");
    $jsonData = json_decode($data, true);

    return view('/', ['jsonData' => $jsonData]);
    }

        public function updateUsersFromJson($jsonData)
    {
        foreach ($jsonData['documents'] as $documents) {
            \App\Models\Documents::updateOrCreate(
                ['id' => $documents['id']],
                [
                    'case_id' => $documents['case_id'],
                    'filename' => $documents['filename'],
                    'mime_type' => $documents['mime_type'],
                    'ategory' => $documents['ategory'],
                    'pages' => $documents['pages'],
                    'uploaded_by' => $documents['uploaded_by'],
                ]
            );
        }
    }
}
