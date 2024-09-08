<?php

namespace App\Service\Data\Riot;

use App\Repository\Account\User\RiotInfoRepository;
use App\Repository\App\Tracker\GameRepository;
use App\Service\Api\Riot\RiotApiService;

class RiotLastGameDataService
{
    public function __construct(
        private RiotApiService $riotApiService,
        private GameRepository $gameRepository,
        private RiotInfoRepository $riotInfoRepository
    ) {
    }

    public function getLastGameData($puuid, $timestamp, $trackerId): array
    {
        $matchId = $this->riotApiService->getLastMatchByPuuid($puuid, $timestamp);

        if (empty($matchId)) {
            return [
                'gameData' => [],
                'leagueData' => [],
            ];
        }

        $matchId = array_values($matchId)[0];

        $summonerId = $this->riotInfoRepository->findOneBy(['puuid' => $puuid])->getSummonerId();
        $leagueData = $this->riotApiService->getLeagueDataBySummonerId($summonerId);

        if (empty($leagueData)) {
            return [
                'gameData' => [],
                'leagueData' => [],
            ];
        }

        $leagueData = array_filter($leagueData, function ($league) {
            return 'RANKED_SOLO_5x5' === $league['queueType'];
        });

        if (empty($leagueData)) {
            return [
                'gameData' => [],
                'leagueData' => [],
            ];
        }

        $leagueData = array_values($leagueData)[0];

        $gameData = [];

        if (!$this->gameRepository->existsByMatchIdAndTrackerId($matchId, $trackerId)) {
            $gameData = $this->riotApiService->getGameDataByMatchId($matchId);
        }

        return [
            'gameData' => $gameData,
            'leagueData' => $leagueData,
        ];
    }
}
