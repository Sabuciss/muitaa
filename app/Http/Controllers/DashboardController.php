<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Vehicles, Cases, Inspections, Documents, Parties};
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private function fetchJson()
    {
        return json_decode(file_get_contents('https://deskplan.lv/muita/app.json'), true);
    }

    public function index()
    {
        $json = $this->fetchJson();
        
        $apiCases = $json['cases'] ?? [];
        $dbCases = Cases::with(['declarant', 'consignee', 'vehicle'])->get();
        
        $cases = collect($apiCases)->map(function($apiCase) use ($dbCases) {
            $dbCase = $dbCases->firstWhere('id', $apiCase['id']);
            if ($dbCase) {
                $apiCase['hs_code'] = $dbCase->hs_code;
                $apiCase['declarant_name'] = $dbCase->declarant?->name;
                $apiCase['consignee_name'] = $dbCase->consignee?->name;
            }
            return $apiCase;
        })->toArray();

        return view('dashboard', [
            'cases' => $cases,
            'vehicles' => $json['vehicles'] ?? [],
            'users' => $json['users'] ?? [],
            'inspections' => $json['inspections'] ?? [],
            'documents' => Documents::all()->toArray(),
            'parties' => $json['parties'] ?? [],
            'totals' => $json['total'] ?? null,
            'userRole' => auth()->user()->role,
            'preferences' => session('user_preferences', [
                'can_view_documents' => true,
                'can_view_inspections' => true,
                'can_view_vehicles' => true,
                'can_view_cases' => true,
            ]),
        ]);
    }

    public function welcome()
    {
        $json = $this->fetchJson();
        $table = request('table', 'all');
        $tables = ['cases', 'vehicles', 'users', 'inspections', 'documents', 'parties'];

        $data = [];
        foreach ($tables as $t) {
            $data[$t] = ($table === 'all' || $table === $t) ? ($json[$t] ?? []) : [];
        }

        return view('welcome', [
            ...$data,
            'totals' => $json['total'] ?? [
                'vehicles' => count($json['vehicles'] ?? []),
                'parties' => count($json['parties'] ?? []),
                'users' => count($json['users'] ?? []),
                'cases' => count($json['cases'] ?? []),
                'inspections' => count($json['inspections'] ?? []),
                'documents' => Documents::count(),
            ],
            'selectedVehicleId' => request('vehicle'),
            'selectedCaseId' => request('case'),
            'selectedUserId' => request('user'),
            'activeTable' => $table,
        ]);
    }

    public function dumpDb()
    {
        return response()->json([
            'users' => User::all(),
            'vehicles' => Vehicles::all(),
            'cases' => Cases::all(),
            'inspections' => Inspections::all(),
            'documents' => Documents::all(),
            'parties' => Parties::all(),
        ]);
    }

    public function importDb()
    {
        $json = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();
        $models = ['users' => User::class, 'vehicles' => Vehicles::class, 'cases' => Cases::class,
                   'inspections' => Inspections::class, 'documents' => Documents::class, 'parties' => Parties::class];

        foreach ($models as $key => $model) {
            foreach ($json[$key] ?? [] as $item) {
                if (!empty($item['id'])) {
                    $model::updateOrCreate(['id' => $item['id']], $item);
                }
            }
        }

        return redirect('dashboard')->with('status', 'Imported successfully');
    }
}
