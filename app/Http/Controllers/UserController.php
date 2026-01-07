<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
     public function showDataFromJson()
    {
    $data = file_get_contents("https://deskplan.lv/muita/app.json");
    $jsonData = json_decode($data, true);

    return view('/', ['jsonData' => $jsonData]);
    }

        public function updateUsersFromJson($jsonData)
    {
        foreach ($jsonData['user'] as $user) {
            \App\Models\User::updateOrCreate(
                ['id' => $user['id']],
                [
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'active' => $user['active'],
                ]
            );
        }
    }
}
