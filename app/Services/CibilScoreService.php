<?php

namespace App\Services;

use Carbon\Carbon;

class CibilScoreService
{
    /**
     * Simulate fetching a CIBIL score.
     *
     * @param string $panNumber
     * @return array
     */
    public function fetchCibilScore(string $panNumber): array
    {
        // Simulate API latency
        // sleep(1);

        // Mock Logic: Return a random score between 300 and 900
        // In a real scenario, this would be an HTTP request to a CIBIL provider
        $score = rand(650, 850); // Skewed towards "good" scores for demo

        return [
            'success' => true,
            'data' => [
                'pan' => $panNumber,
                'cibil_score' => $score,
                'report_date' => Carbon::now()->toDateTimeString(),
                'provider' => 'MockCibilProvider',
            ]
        ];
    }
}
