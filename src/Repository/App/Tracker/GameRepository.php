<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    // TRACKER
    public function findGamesByTracker($trackerId): Query
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g', 'i')
            ->join('g.tracker', 'i')
            ->where('i.id = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->orderBy('g.gameCreation', 'DESC');

        return $qb->getQuery();
    }

    public function findWinsByDate(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g')
            ->join('g.tracker', 'i')
            ->orderBy('g.gameCreation', 'ASC');

        $games = $qb->getQuery()->getResult();

        $winsByDate = [];
        foreach ($games as $game) {
            $date = (new \DateTime())->setTimestamp($game->getGameCreation() / 1000)->format('Y-m-d');
            $trackerId = $game->getTracker()->getId();

            if (!isset($winsByDate[$trackerId][$date])) {
                $winsByDate[$trackerId][$date] = 0;
            }

            if (true === $game->isWin()) {
                ++$winsByDate[$trackerId][$date];
            }
        }

        return $winsByDate;
    }

    public function findLossesByDate(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g')
            ->join('g.tracker', 'i')
            ->orderBy('g.gameCreation', 'ASC');

        $games = $qb->getQuery()->getResult();

        $lossesByDate = [];
        foreach ($games as $game) {
            $date = (new \DateTime())->setTimestamp($game->getGameCreation() / 1000)->format('Y-m-d');
            $trackerId = $game->getTracker()->getId();

            if (false === $game->isEligibleForProgression()) {
                continue;
            }

            if (!isset($lossesByDate[$trackerId][$date])) {
                $lossesByDate[$trackerId][$date] = 0;
            }

            if (false === $game->isWin()) {
                ++$lossesByDate[$trackerId][$date];
            }
        }

        return $lossesByDate;
    }

    public function findLpvarByDateAndByTracker($trackerId): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g')
            ->join('g.tracker', 'i')
            ->where('i.id = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->orderBy('g.gameCreation', 'ASC');

        $games = $qb->getQuery()->getResult();

        $lpvarByDate = [];
        foreach ($games as $game) {
            $date = (new \DateTime())->setTimestamp($game->getGameCreation() / 1000)->format('Y-m-d');

            if (!isset($lpvarByDate[$date])) {
                $lpvarByDate[$date] = 0;
            }

            $lpvarByDate[$date] += $game->getLpvar();
        }

        return $lpvarByDate;
    }

    public function findLasttGameByDateAndByTracker($trackerId): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g')
            ->join('g.tracker', 'i')
            ->where('i.id = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->orderBy('g.gameCreation', 'ASC');

        $games = $qb->getQuery()->getResult();

        $lastGameByDate = [];
        foreach ($games as $game) {
            $date = (new \DateTime())->setTimestamp($game->getGameCreation() / 1000)->format('Y-m-d');

            $lastGameByDate[$date] = $game;
        }

        return $lastGameByDate;
    }

    public function existsByMatchIdAndTrackerId($matchId, $trackerId): bool
    {
        $qb = $this->createQueryBuilder('g');
        $qb->where('g.matchId = :matchId')
            ->andWhere('g.tracker = :trackerId')
            ->setParameters([
                'matchId' => $matchId,
                'trackerId' => $trackerId,
            ]);

        $result = $qb->getQuery()->getOneOrNullResult();

        return null !== $result;
    }
}
