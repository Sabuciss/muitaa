<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Inspections;

class UserController extends Controller
{
    private function authorizeRoles($roles)
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, $roles), 403);
    }

    public function createDocument()
    {
        return view('documents.create');
    }

    public function storeDocument(Request $request)
    {
        $request->validate(['case_id' => 'required', 'filename' => 'required']);

        Documents::create([
            'id' => 'doc-' . uniqid(),
            ...$request->only(['case_id', 'category', 'filename', 'mime_type', 'pages']),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect('dashboard')->with('status', 'Document saved.');
    }

    public function editDocument(string $id)
    {
        return view('documents.edit', ['document' => Documents::findOrFail($id)]);
    }

    public function updateDocument(Request $request, string $id)
    {
        $request->validate(['filename' => 'required']);

        Documents::findOrFail($id)->update($request->only(['category', 'filename', 'mime_type', 'pages']));

        return redirect('dashboard')->with('status', 'Document updated.');
    }

    public function deleteDocument(string $id)
    {
        Documents::findOrFail($id)->delete();
        return redirect('dashboard')->with('status', 'Document deleted.');
    }

    public function createInspection()
    {
        return view('inspections.create');
    }

    public function storeInspection(Request $request)
    {
        $request->validate(['case_id' => 'required', 'type' => 'required', 'location' => 'required']);

        Inspections::create([
            'id' => 'insp-' . uniqid(),
            ...$request->only(['case_id', 'type', 'location']),
            'start_ts' => $request->start_ts ? $request->start_ts . ' 00:00:00' : now(),
            'checks' => $request->checks ? json_encode(explode(',', $request->checks)) : null,
            'assigned_to' => auth()->id(),
            'requested_by' => auth()->id(),
        ]);

        return redirect('dashboard')->with('status', 'Inspection saved.');
    }

    public function editInspection(string $id)
    {
        return view('inspections.edit', ['inspection' => Inspections::findOrFail($id)]);
    }

    public function updateInspection(Request $request, string $id)
    {
        $request->validate(['type' => 'required', 'location' => 'required']);

        Inspections::findOrFail($id)->update([
            ...$request->only(['type', 'location']),
            'start_ts' => $request->start_ts ? $request->start_ts . ' 00:00:00' : now(),
            'checks' => $request->checks ? json_encode(explode(',', $request->checks)) : null,
        ]);

        return redirect('dashboard')->with('status', 'Inspection updated.');
    }

    public function deleteInspection(string $id)
    {
        Inspections::findOrFail($id)->delete();
        return redirect('dashboard')->with('status', 'Inspection deleted.');
    }

    public function createAnalysis()
    {
        return view('analysis.create');
    }

    public function storeAnalysis(Request $request)
    {
        $validated = $request->validate([
            'case_id' => 'required|string',
            'risk_level' => 'required|string',
            'findings' => 'nullable|string',
        ]);

        try {
            Inspections::create([
                'id' => 'risk-' . uniqid(),
                'case_id' => $validated['case_id'],
                'type' => 'risk_analysis',
                'location' => 'Risk Assessment',
                'checks' => json_encode([
                    'risk_level' => $validated['risk_level'],
                    'findings' => $validated['findings'] ?? null,
                ]),
                'assigned_to' => auth()->id(),
                'requested_by' => auth()->id(),
            ]);

            return redirect('dashboard')->with('status', 'Risk analysis created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create analysis: ' . $e->getMessage());
        }
    }

    public function editAnalysis(string $id)
    {
        return view('analysis.edit', ['analysis' => Inspections::findOrFail($id)]);
    }

    public function updateAnalysis(Request $request, string $id)
    {
        $request->validate(['risk_level' => 'required']);

        Inspections::findOrFail($id)->update([
            'checks' => json_encode(['risk_level' => $request->risk_level, 'findings' => $request->findings ?? null]),
        ]);

        return redirect('dashboard')->with('status', 'Risk analysis updated.');
    }

    public function deleteAnalysis(string $id)
    {
        Inspections::findOrFail($id)->delete();
        return redirect('dashboard')->with('status', 'Risk analysis deleted.');
    }
}