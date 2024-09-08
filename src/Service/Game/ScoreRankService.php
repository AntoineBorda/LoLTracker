<?php

namespace App\Service\Game;

class ScoreRankService
{
    public function rankToNumericValue($tier, $rank, $leaguPoints)
    {
        $tierValues = [
            'UNRANKED' => 0,
            'IRON' => 100,
            'BRONZE' => 200,
            'SILVER' => 300,
            'GOLD' => 400,
            'PLATINUM' => 500,
            'EMERALD' => 600,
            'DIAMOND' => 700,
            'MASTER' => 800,
            'GRANDMASTER' => 900,
            'CHALLENGER' => 1000,
        ];
        $rankValues = [
            'IV' => 1,
            'III' => 2,
            'II' => 3,
            'I' => 4,
        ];

        if (in_array($tier, ['MASTER', 'GRANDMASTER', 'CHALLENGER'])) {
            return $tierValues[$tier] + $rankValues[$rank] + $leaguPoints;
        }

        return $tierValues[$tier] + $rankValues[$rank];
    }
}
