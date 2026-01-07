<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // Lai var filtrēt pēc request parametriem (piemēram, ?vehicle=veh-000001)
        $selectedVehicleId = request('vehicle');
        $selectedCaseId    = request('case');
        $selectedUserId    = request('user');
        // Apply filters to inspections server-side so the view shows matching items only.
        $inspections = array_filter($inspections, function ($i) use ($selectedCaseId, $selectedUserId, $selectedVehicleId, $cases) {
            // Filter by case id
            if (!empty($selectedCaseId) && (!isset($i['case_id']) || $i['case_id'] !== $selectedCaseId)) {
                return false;
            }

            // Filter by user who requested the inspection
            if (!empty($selectedUserId) && (!isset($i['requested_by']) || $i['requested_by'] !== $selectedUserId)) {
                return false;
            }

            // Filter by vehicle: lookup the case and compare its vehicle_id (if present)
            if (!empty($selectedVehicleId)) {
                $caseId = $i['case_id'] ?? null;
                if (!$caseId) {
                    return false;
                }

                // find the case in $cases array
                $matchingCase = null;
                foreach ($cases as $c) {
                    if (isset($c['id']) && $c['id'] === $caseId) {
                        $matchingCase = $c;
                        break;
                    }
                }

                // If case not found or it doesn't have a vehicle_id, treat as non-matching
                if (!$matchingCase || !isset($matchingCase['vehicle_id']) || $matchingCase['vehicle_id'] !== $selectedVehicleId) {
                    return false;
                }
            }

            return true;
        });

        // Re-index filtered inspections for predictable iteration in the view
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
}
