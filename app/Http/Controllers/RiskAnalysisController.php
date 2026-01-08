<?php

namespace App\Http\Controllers;

use App\Services\RiskAnalysisService;
use App\Models\Cases;

class RiskAnalysisController extends Controller
{
    private RiskAnalysisService $riskService;

    public function __construct(RiskAnalysisService $riskService)
    {
        $this->riskService = $riskService;
    }

    public function index()
    {
        $cases = Cases::get();
        $analysis = [];

        foreach ($cases as $case) {
            $riskScore = $this->riskService->calculateRiskScore($case->id);
            
            $analysis[] = [
                'case_id' => $case->id,
                'vehicle_id' => $case->vehicle_id,
                'origin' => $case->origin_country,
                'destination' => $case->destination_country,
                'value' => $case->cargo_value ?? 0,
                'risk_score' => $riskScore,
                'risk_level' => (int)$riskScore,
                'should_inspect' => $this->riskService->shouldGenerateInspection($riskScore),
            ];
        }

        usort($analysis, function ($a, $b) {
            return $b['risk_score'] <=> $a['risk_score'];
        });

        return view('analysis.risk', [
            'analysis' => $analysis,
            'userRole' => auth()->user()->role,
        ]);
    }

    public function generateInspection($caseId)
    {
        $riskScore = $this->riskService->calculateRiskScore($caseId);
        
        if (!$this->riskService->shouldGenerateInspection($riskScore)) {
            return back()->with('error', 'Risk score too low to generate inspection.');
        }

        $this->riskService->generateInspectionTask($caseId, (int)$riskScore, $riskScore);

        return back()->with('status', "Inspection task generated for case: $caseId");
    }
}
