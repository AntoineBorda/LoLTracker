<?php

namespace App\Service\Data\Tracker;

use App\Repository\App\Tracker\GameRepository;
use App\Repository\App\Tracker\TrackerRepository;

class TrackerDataService
{
    public function __construct(
        private readonly TrackerRepository $trackerRepository,
        private readonly GameRepository    $gameRepository
    ) {
    }

    public function getDataForTracker(int $trackerId): array
    {
        $tracker = $this->trackerRepository->findOneBy(['id' => $trackerId]);
        // $gamesByTracker = $this->gameRepository->findGamesByTracker($tracker);
        $firstGameByTracker = $this->trackerRepository->findFirstGameForTracker($trackerId);
        $lastGameByTracker = $this->trackerRepository->findLastGameForTracker($trackerId);
        $lasttGameByDateAndByTracker = $this->gameRepository->findLasttGameByDateAndByTracker($trackerId);
        $winsByDate = $this->gameRepository->findWinsByDate();
        $lossesByDate = $this->gameRepository->findLossesByDate();
        $lpvarByDateAndByTracker = $this->gameRepository->findLpvarByDateAndByTracker($trackerId);

        return [
            'tracker' => $tracker,
            // 'gamesByTracker' => $gamesByTracker,
            'firstGameByTracker' => $firstGameByTracker,
            'lastGameByTracker' => $lastGameByTracker,
            'lasttGameByDateAndByTracker' => $lasttGameByDateAndByTracker,
            'winsByDate' => $winsByDate,
            'lossesByDate' => $lossesByDate,
            'lpvarByDateAndByTracker' => $lpvarByDateAndByTracker,
        ];
    }
}
