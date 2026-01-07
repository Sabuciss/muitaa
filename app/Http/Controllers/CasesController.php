<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cases;

class CasesController extends Controller
{
    public function index()
    {
        $cases = Cases::orderBy('arrival_ts', 'desc')->get();
        return view('cases.index', compact('cases'));
    }

    public function create()
    {
        return view('cases.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|unique:cases',
            'external_ref' => 'nullable|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'arrival_ts' => 'nullable|string',
            'vehicle_id' => 'nullable|string',
        ]);

        Cases::create($data);

        return redirect()->route('cases.index')->with('success', 'Case created successfully!');
    }

    public function edit($id)
    {
        $case = Cases::findOrFail($id);
        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = Cases::findOrFail($id);
        $data = $request->validate([
            'external_ref' => 'nullable|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'arrival_ts' => 'nullable|string',
            'vehicle_id' => 'nullable|string',
        ]);

        $case->update($data);

        return redirect()->route('cases.index')->with('success', 'Case updated successfully!');
    }

    public function destroy($id)
    {
        $case = Cases::findOrFail($id);
        $case->delete();
        return redirect()->route('cases.index')->with('success', 'Case deleted successfully!');
    }
}
