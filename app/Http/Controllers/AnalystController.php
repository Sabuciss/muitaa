<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Inspections;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    public function index()
    {
        $json = json_decode(file_get_contents('https://deskplan.lv/muita/app.json'), true);
        $cases = $json['cases'] ?? [];
        
        return view('analyst.dashboard', [
            'cases' => $cases,
            'totals' => $json['total'] ?? null,
        ]);
    }

    public function runRisk($id)
    {
        $case = Cases::findOrFail($id);
        // Risk analysis logic here
        return back()->with('status', 'Risk analysis completed for case: ' . $id);
    }

    public function runAllRisk()
    {
        // Run risk analysis for all cases
        return back()->with('status', 'Risk analysis completed for all cases');
    }

    public function createAnalysis()
    {
        return view('analysis.create');
    }

    public function storeAnalysis(Request $request)
    {
        $request->validate([
            'case_id' => 'required',
            'risk_level' => 'required|integer|min:1|max:5',
        ]);

        // Store analysis record
        $analysis = [
            'id' => 'analysis-' . uniqid(),
            'case_id' => $request->case_id,
            'risk_level' => $request->risk_level,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ];

        return redirect()->route('dashboard')->with('status', 'Risk analysis created successfully.');
    }

    public function editAnalysis($id)
    {
        // In a real app, you'd fetch from database
        return view('analysis.edit', ['analysis' => ['id' => $id]]);
    }

    public function updateAnalysis(Request $request, $id)
    {
        $request->validate([
            'risk_level' => 'required|integer|min:1|max:5',
        ]);

        return redirect()->route('dashboard')->with('status', 'Risk analysis updated successfully.');
    }

    public function deleteAnalysis($id)
    {
        return redirect()->route('dashboard')->with('status', 'Risk analysis deleted successfully.');
    }
}
