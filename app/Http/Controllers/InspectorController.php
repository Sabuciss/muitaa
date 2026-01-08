<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Inspections;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
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

    public function decision(Request $request, $id)
    {
        $inspection = Inspections::findOrFail($id);
        $request->validate(['decision' => 'required|in:release,hold,reject']);
        
        $inspection->update(['status' => $request->decision]);
        
        return back()->with('status', 'Decision recorded: ' . $request->decision);
    }

    public function createInspection()
    {
        return view('inspections.create');
    }

    public function storeInspection(Request $request)
    {
        $request->validate([
            'case_id' => 'required',
            'type' => 'required|string',
            'location' => 'nullable|string',
            'start_ts' => 'nullable|date',
            'checks' => 'nullable|string',
        ]);

        $checks = [];
        if ($request->checks) {
            $checks = array_map('trim', explode(',', $request->checks));
        }

        Inspections::create([
            'id' => 'insp-' . uniqid(),
            'case_id' => $request->case_id,
            'type' => $request->type,
            'location' => $request->location,
            'start_ts' => $request->start_ts,
            'checks' => $checks,
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
        ]);

        $inspection->update($request->only(['type']));
        return redirect()->route('dashboard')->with('status', 'Inspection updated successfully.');
    }

    public function deleteInspection($id)
    {
        Inspections::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('status', 'Inspection deleted successfully.');
    }
}
