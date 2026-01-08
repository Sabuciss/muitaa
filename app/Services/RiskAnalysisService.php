<?php

namespace App\Services;

use App\Models\Cases;
use App\Models\Inspections;

class RiskAnalysisService
{
    private const HIGH_RISK_CODES = ['8704', '9000', '7210', '8471'];
    private const HIGH_RISK_COUNTRIES = ['IR', 'KP', 'SY'];

    public function calculateRiskScore($caseId)
    {
        $case = Cases::find($caseId);
        
        if (!$case) {
            return null;
        }

        $score = 1; // Base score
        $score += $this->scoreHSCode($case->hs_code);
        $score += $this->scoreRoute($case->origin_country, $case->destination_country);
        $score += $this->scoreValue($case->cargo_value ?? 0);
        $score += $this->scoreViolations($caseId);

        return min($score, 5); 
    }

    private function scoreHSCode($code)
    {
        if (!$code) {
            return 0;
        }

        foreach (self::HIGH_RISK_CODES as $riskCode) {
            if (str_starts_with($code, $riskCode)) {
                return 2;
            }
        }

        return 0;
    }

    private function scoreRoute($origin, $destination)
    {
        $score = 0;

        if (in_array($origin, self::HIGH_RISK_COUNTRIES)) {
            $score += 1;
        }

        if (in_array($destination, self::HIGH_RISK_COUNTRIES)) {
            $score += 1;
        }

        return $score;
    }

    private function scoreValue($value)
    {
        return $value > 10000 ? 1 : 0;
    }

    private function scoreViolations($caseId)
    {
        return min(Inspections::where('case_id', $caseId)->where('violation', true)->count(), 1);
    }

    public function shouldGenerateInspection($score)
    {
        return $score >= 4;
    }

    public function generateInspectionTask($caseId, $level, $score)
    {
        $inspectionId = 'insp-' . uniqid();
        $location = "Automated - Risk Score: $score";
        $requestedBy = auth()->user()->api_id ?? 'system';

        Inspections::create([
            'id' => $inspectionId,
            'case_id' => $caseId,
            'type' => 'risk-based',
            'location' => $location,
            'risk_level' => $level,
            'status' => 'pending',
            'assigned_to' => null,
            'requested_by' => $requestedBy,
        ]);
    }
}
