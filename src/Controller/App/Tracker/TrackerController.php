<?php

namespace App\Controller\App\Tracker;

use App\Repository\App\Tracker\GameRepository;
use App\Service\Data\Tracker\TrackerDataService;
use App\Service\Paginator\PaginatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracker')]
class TrackerController extends AbstractController
{
    public function __construct(
        private readonly PaginatorService $paginatorService,
        private readonly TrackerDataService $trackerDataService
    ) {
    }

    #[Route('/player-tracker/{tracker_id}', name: 'app_tracker_playertracker', methods: ['GET'])]
    public function playerTrackerDisplay(
        int $tracker_id,
        GameRepository $gameRepository,
    ): Response {
        $data = $this->trackerDataService->getDataForTracker($tracker_id);
        $query = $gameRepository->findGamesByTracker($tracker_id);
        $gamesPagination = $this->paginatorService->paginate($query, 40);
        $gamesByDate = [];
        foreach ($gamesPagination as $game) {
            $date = (new \DateTime())->setTimestamp($game->getGameCreation() / 1000)->format('Y-m-d');
            $gamesByDate[$date][] = $game;
        }

        return $this->render('pages/app/tracker/tracker/index.html.twig', [
            'gamesByDate' => $gamesByDate,
            'gamesPagination' => $gamesPagination,
            'data' => $data,
        ]);
    }
}
