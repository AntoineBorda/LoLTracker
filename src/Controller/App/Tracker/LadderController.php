<?php

namespace App\Controller\App\Tracker;

use App\Repository\App\Tracker\DataChampionRepository;
use App\Repository\App\Tracker\TrackerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LadderController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function ladderDisplay(
        TrackerRepository $trackerRepository,
        DataChampionRepository $dataChampionRepository,
    ): Response {
        $trackers = $trackerRepository->findAll();
        $trackersData = [];

        foreach ($trackers as $tracker) {
            $lastGame = $trackerRepository->findLastGameForTracker($tracker->getId());
            $mostTeamposition = $trackerRepository->findMostTeampositionFortracker($tracker->getId());
            $mostUsedChampions = $trackerRepository->findMostUsedChampionsForTracker($tracker->getId());
            $mostUsedChampions = array_map(function ($champion) use ($dataChampionRepository) {
                return $dataChampionRepository->find($champion['championId']);
            }, $mostUsedChampions);

            $trackersData[] = [
                'tracker' => $tracker,
                'lastGame' => $lastGame,
                'mostTeamposition' => $mostTeamposition,
                'mostUsedChampions' => $mostUsedChampions,
            ];
        }

        usort(
            $trackersData,
            function ($a, $b) {
                $aScore = $a['lastGame'] ? $a['lastGame']->getScoreRank() : -PHP_INT_MAX;
                $bScore = $b['lastGame'] ? $b['lastGame']->getScoreRank() : -PHP_INT_MAX;

                // Pour un tri décroissant, inversez l'ordre de $aScore et $bScore dans la comparaison.
                return $bScore <=> $aScore;
            }
        );

        $rank = 1;
        foreach ($trackersData as &$trackerWithGame) {
            $trackerWithGame['rank'] = $rank++;
        }

        return $this->render('pages/app/tracker/ladder/index.html.twig', [
            'trackersData' => $trackersData,
        ]);
    }

    #[Route('/change-language/{locale}', name: 'change_language')]
    public function changeLanguage(
        string $locale,
        Request $request,
        SessionInterface $session
    ) {
        $session->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer') ?: '/');
    }
}
