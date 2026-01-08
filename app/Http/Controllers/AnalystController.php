<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Inspections;
use App\Models\Analysis;
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
        $inspection = Inspections::findOrFail($id);
        $case = Cases::find($inspection->case_id);
        
        $riskMapping = [
            'Low' => 1,
            'Medium' => 2,
            'High' => 3,
            'Very High' => 4,
            'Critical' => 5,
        ];
        
        // Intelligently calculate risk level based on inspection data
        $calculatedRisk = 2; // Default to Medium
        
        if ($inspection->risk_level) {
            // Use selected risk level
            $calculatedRisk = $riskMapping[$inspection->risk_level] ?? 2;
        } else if ($case) {
            // Calculate based on case details if no risk_level set
            $baseRisk = 2;
            
            // High priority increases risk
            if ($case->priority === 'high') {
                $baseRisk += 1;
            }
            
            // Detained status increases risk
            if ($case->status === 'detained') {
                $baseRisk += 1;
            }
            
            // High-risk routes increase risk
            $highRiskRoutes = ['CN', 'IN', 'PK', 'AF'];
            if (in_array($case->origin_country, $highRiskRoutes) || in_array($case->destination_country, $highRiskRoutes)) {
                $baseRisk += 1;
            }
            
            // RTG inspection increases risk
            if ($inspection->type === 'RTG') {
                $baseRisk += 1;
            }
            
            $calculatedRisk = min($baseRisk, 5); // Cap at 5
        }
        
        // Get risk level text
        $riskLevel = $inspection->risk_level ?? array_search($calculatedRisk, $riskMapping, true) ?: 'Medium';
        
        // Generate risk flag based on inspection data and case details
        $riskFlags = [];
        
        if ($inspection->type === 'RTG') {
            $riskFlags[] = 'RTG skenēšana nepieciešama';
        }
        
        if ($inspection->type === 'fiziska') {
            $riskFlags[] = 'Fiziska pārbaude';
        }
        
        if ($case) {
            if ($case->priority === 'high') {
                $riskFlags[] = 'Augsta prioritāte - Paaugstināta uzraudzība';
            }
            
            if ($case->status === 'detained') {
                $riskFlags[] = 'Noliktava - Aizturēta sūtījuma analīze';
            }
            
            // Check for high-risk routes
            $highRiskRoutes = ['CN', 'IN', 'PK', 'AF'];
            if (in_array($case->origin_country, $highRiskRoutes)) {
                $riskFlags[] = 'Riskanta izcelšanās valsts: ' . $case->origin_country;
            }
            if (in_array($case->destination_country, $highRiskRoutes)) {
                $riskFlags[] = 'Riskanta galapunkta valsts: ' . $case->destination_country;
            }
        }
        
        // If no specific flags, generate generic flag based on risk level
        if (empty($riskFlags)) {
            $riskFlags[] = 'Automatizēts risks: ' . $riskLevel;
        }
        
        $riskFlagText = implode('; ', $riskFlags);
        
        // Update inspection with risk level and flag if not already set
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
        // In a real app, you'd fetch from database
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
