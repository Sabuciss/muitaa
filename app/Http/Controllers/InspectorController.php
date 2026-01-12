<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Inspections;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    private function parseChecks($checksString)
    {
        if (!$checksString) return [];
        return array_map('trim', explode(',', $checksString));
    }
    public function index()
    {
        $json = json_decode(file_get_contents('https://deskplan.lv/muita/app.json'), true);
        $cases = $json['cases'] ?? [];
        $inspections = $json['inspections'] ?? [];
        
        return view('inspector.dashboard', [
            'cases' => $cases,
            'inspections' => $inspections,
            'totals' => $json['total'] ?? null,
        ]);
    }

    public function show($caseId)
    {
        $case = Cases::findOrFail($caseId);
        $inspections = Inspections::where('case_id', $caseId)->get();
        
        return view('inspector.case', compact('case', 'inspections'));
    }

    public function createInspection()
    {
        return view('inspections.create');
    }

    public function storeInspection(Request $request)
    {
        $request->validate([
            'case_id' => 'required',
            'type' => 'required|in:dokumentu,fiziska,RTG',
            'risk_level' => 'required|string|in:Low,Medium,High,Very High,Critical',
            'location' => 'nullable|string',
            'start_ts' => 'nullable|date',
            'checks' => 'nullable|string',
        ]);

        Inspections::create([
            'id' => 'insp-' . uniqid(),
            'case_id' => $request->case_id,
            'type' => $request->type,
            'risk_level' => $request->risk_level,
            'location' => $request->location,
            'start_ts' => $request->start_ts ?: null,
            'checks' => $this->parseChecks($request->checks),
            'requested_by' => auth()->user()->full_name ?? auth()->user()->name,
        ]);

        return redirect()->route('dashboard')->with('status', 'Inspection created successfully.');
    }

    public function editInspection($id)
    {
        $inspection = Inspections::findOrFail($id);
        return view('inspections.edit', compact('inspection'));
    }

    public function updateInspection(Request $request, $id)
    {
        $inspection = Inspections::findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:dokumentu,RTG,fiziska',
            'risk_level' => 'required|string|in:Low,Medium,High,Very High,Critical',
            'location' => 'required|string',
            'start_ts' => 'required|date',
            'checks' => 'nullable|string',
            'decision' => 'nullable|in:released,hold,reject',
            'comments' => 'nullable|string',
            'justifications' => 'nullable|string',
        ]);

        $inspection->update([
            'type' => $request->type,
            'risk_level' => $request->risk_level,
            'location' => $request->location,
            'start_ts' => $request->start_ts,
            'checks' => $this->parseChecks($request->checks),
            'decision' => $request->decision,
            'comments' => $request->comments,
            'justifications' => $request->justifications,
        ]);

        return redirect()->route('dashboard')->with('status', 'Inspection updated successfully.');
    }

    public function deleteInspection($id)
    {
        Inspections::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('status', 'Inspection deleted successfully.');
    }

    public function decision(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:released,hold,reject',
            'comments' => 'nullable|string',
            'justifications' => 'nullable|string',
        ]);

        $inspection = Inspections::findOrFail($id);

        $inspection->update([
            'decision' => $request->decision,
            'comments' => $request->comments,
            'justifications' => $request->justifications,
            'end_ts' => now(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Inspection decision saved!');
    }
}
