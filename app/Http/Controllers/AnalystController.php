<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Inspections;
use App\Models\Analysis;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    private $riskMapping = [
        'Low' => 1,
        'Medium' => 2,
        'High' => 3,
        'Very High' => 4,
        'Critical' => 5,
    ];

    private $highRiskRoutes = ['CN', 'IN', 'PK', 'AF'];

    public function index()
    {
        $json = json_decode(file_get_contents('https://deskplan.lv/muita/app.json'), true);
        
        return view('analyst.dashboard', [
            'cases' => $json['cases'] ?? [],
            'totals' => $json['total'] ?? null,
        ]);
    }

    private function calculateRisk($inspection, $case)
    {
        if ($inspection->risk_level) {
            return $this->riskMapping[$inspection->risk_level] ?? 2;
        }

        if (!$case) return 2;

        $risk = 2;
        $risk += ($case->priority === 'high') ? 1 : 0;
        $risk += ($case->status === 'detained') ? 1 : 0;
        $risk += (in_array($case->origin_country, $this->highRiskRoutes) || in_array($case->destination_country, $this->highRiskRoutes)) ? 1 : 0;
        $risk += ($inspection->type === 'RTG') ? 1 : 0;

        return min($risk, 5);
    }

    private function generateRiskFlags($inspection, $case, $calculatedRisk)
    {
        $flags = [];

        if ($inspection->type === 'RTG') {
            $flags[] = 'RTG skenēšana nepieciešama';
        }
        if ($inspection->type === 'fiziska') {
            $flags[] = 'Fiziska pārbaude';
        }

        if ($case) {
            if ($case->priority === 'high') {
                $flags[] = 'Augsta prioritāte - Paaugstināta uzraudzība';
            }
            if ($case->status === 'detained') {
                $flags[] = 'Noliktava - Aizturēta sūtījuma analīze';
            }
            if (in_array($case->origin_country, $this->highRiskRoutes)) {
                $flags[] = 'Riskanta izcelšanās valsts: ' . $case->origin_country;
            }
            if (in_array($case->destination_country, $this->highRiskRoutes)) {
                $flags[] = 'Riskanta galapunkta valsts: ' . $case->destination_country;
            }
        }

        if (empty($flags)) {
            $riskLevel = array_search($calculatedRisk, $this->riskMapping, true) ?: 'Medium';
            $flags[] = 'Automatizēts risks: ' . $riskLevel;
        }

        return implode('; ', $flags);
    }

    public function runRisk($id)
    {
        $inspection = Inspections::findOrFail($id);
        $case = Cases::find($inspection->case_id);

        $calculatedRisk = $this->calculateRisk($inspection, $case);
        $riskLevel = $inspection->risk_level ?? array_search($calculatedRisk, $this->riskMapping, true) ?: 'Medium';
        $riskFlagText = $this->generateRiskFlags($inspection, $case, $calculatedRisk);

        $updateData = ['risk_flag' => $riskFlagText];
        if (!$inspection->risk_level) {
            $updateData['risk_level'] = $riskLevel;
        }
        $inspection->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Riska analīze pabeigta.',
            'risk_level' => $riskLevel,
            'rating' => $calculatedRisk,
            'risk_flag' => $riskFlagText,
        ]);
    }

    public function runAllRisk()
    {
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
            'risk_level' => 'required|string|in:Low,Medium,High,Very High,Critical',
        ]);

        Analysis::create([
            'id' => 'analysis-' . uniqid(),
            'case_id' => $request->case_id,
            'risk_level' => $request->risk_level,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Risk analysis created successfully.');
    }

    public function editAnalysis($id)
    {
        return view('analysis.edit', ['analysis' => ['id' => $id]]);
    }

    public function updateAnalysis(Request $request, $id)
    {
        $analysis = Analysis::findOrFail($id);
        $request->validate([
            'risk_level' => 'required|string|in:Low,Medium,High,Very High,Critical',
        ]);

        $analysis->update([
            'risk_level' => $request->risk_level,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('status', 'Risk analysis updated successfully.');
    }

    public function deleteAnalysis($id)
    {
        Analysis::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('status', 'Risk analysis deleted successfully.');
    }
}
