<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        $data = file_get_contents("https://deskplan.lv/muita/app.json");
        $json = json_decode($data, true);

        return view('welcome', [
            'cases' => $json['cases'],
            'vehicles' => $json['vehicles'],
            'users' => $json['users'],
            'inspections' => $json['inspections'],
            'documents' => $json['documents'],
            'parties' => $json['parties'],


        
        ]);
    }
}
