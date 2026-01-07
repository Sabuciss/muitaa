<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;
use App\Models\Cases;
use App\Models\Inspections;
use App\Models\Documents;
use App\Models\Parties;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Nolasām visu no API
        $data = file_get_contents('https://deskplan.lv/muita/app.json');
        $json = json_decode($data, true);

        //  izvelkam masīvus, pat ja kāds nav
        $cases= $json['cases'] ?? [];
        $vehicles= $json['vehicles'] ?? [];
        $users = $json['users'] ?? [];
        $inspections = $json['inspections'] ?? [];
        $documents  = $json['documents'] ?? [];
        $parties= $json['parties'] ?? [];
        $totals = $json['total'] ?? null; // ja API satur total objektu

        // Lai var filtrēt pēc request parametriem
        $selectedVehicleId = request('vehicle');
        $selectedCaseId    = request('case');
        $selectedUserId    = request('user');
        $inspections = array_filter($inspections, function ($i) use ($selectedCaseId, $selectedUserId, $selectedVehicleId, $cases) {
            // Filtrs pēc id
            if (!empty($selectedCaseId) && (!isset($i['case_id']) || $i['case_id'] !== $selectedCaseId)) {
                return false;
            }

            // filrs pēc lietotāja, kas pieprasīja inspekciju
            if (!empty($selectedUserId) && (!isset($i['requested_by']) || $i['requested_by'] !== $selectedUserId)) {
                return false;
            }

            //    filtrs pēc vehicels 
            if (!empty($selectedVehicleId)) {
                $caseId = $i['case_id'] ?? null;
                if (!$caseId) {
                    return false;
                }

                $matchingCase = null;
                foreach ($cases as $c) {
                    if (isset($c['id']) && $c['id'] === $caseId) {
                        $matchingCase = $c;
                        break;
                    }
                }

                if (!$matchingCase || !isset($matchingCase['vehicle_id']) || $matchingCase['vehicle_id'] !== $selectedVehicleId) {
                    return false;
                }
            }

            return true;
        });

        $inspections = array_values($inspections);

        return view('welcome', [
            'cases' => $cases,
            'vehicles' => $vehicles,
            'users'=> $users,
            'inspections' => $inspections,
            'documents'=> $documents,
            'parties' => $parties,
            'totals'=> $totals,
            'selectedVehicleId'=> $selectedVehicleId,
            'selectedCaseId'=> $selectedCaseId,
            'selectedUserId'=> $selectedUserId,
        ]);
    }

    /**
     * Return a JSON dump of main database tables (authenticated users only).
     */
    public function dumpDb()
    {
        $data = [
            'users' => User::all(),
            'vehicles' => Vehicles::all(),
            'cases' => Cases::all(),
            'inspections' => Inspections::all(),
            'documents' => Documents::all(),
            'parties' => Parties::all(),
        ];

        return response()->json($data);
    }

    /**
     * Import data from the remote JSON into local database tables (upsert by id).
     * Protected route should be admin-only in routes.
     */
    public function importDb()
    {
        $source = 'https://deskplan.lv/muita/app.json';
        $raw = @file_get_contents($source);
        if (!$raw) {
            return redirect()->route('dashboard')->with('error', 'Could not fetch remote data');
        }

        $json = json_decode($raw, true);
        if (!is_array($json)) {
            return redirect()->route('dashboard')->with('error', 'Invalid JSON from source');
        }

        $map = [
            'users' => User::class,
            'vehicles' => Vehicles::class,
            'cases' => Cases::class,
            'inspections' => Inspections::class,
            'documents' => Documents::class,
            'parties' => Parties::class,
        ];

        DB::transaction(function () use ($json, $map) {
            foreach ($map as $key => $model) {
                $items = $json[$key] ?? [];
                foreach ($items as $item) {
                    if (empty($item['id'])) {
                        continue;
                    }
                    $attributes = $item;
                    $model::updateOrCreate(['id' => $item['id']], $attributes);
                }
            }
        });

        return redirect()->route('dashboard')->with('status', 'Import completed');
    }
}
