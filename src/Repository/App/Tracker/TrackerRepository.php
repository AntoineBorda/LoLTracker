<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Tracker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tracker>
 *
 * @method Tracker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tracker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tracker[]    findAll()
 * @method Tracker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tracker::class);
    }

    public function findLastGameForTracker($trackerId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('g')
            ->from('App\Entity\App\Tracker\Game', 'g')
            ->where('g.tracker = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->orderBy('g.createdAt', 'DESC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findFirstGameForTracker($trackerId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('g')
            ->from('App\Entity\App\Tracker\Game', 'g')
            ->where('g.tracker = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->orderBy('g.createdAt', 'ASC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findMostTeampositionFortracker($trackerId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('g.teamPosition')
            ->from('App\Entity\App\Tracker\Game', 'g')
            ->where('g.tracker = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->groupBy('g.teamPosition')
            ->orderBy('COUNT(g.teamPosition)', 'DESC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findMostUsedChampionsForTracker($trackerId, $limit = 5)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('IDENTITY(pick.dataChampion) as championId, COUNT(IDENTITY(pick.dataChampion)) AS champCount')
            ->from('App\Entity\App\Tracker\Pick', 'pick')
            ->join('pick.game', 'game')
            ->where('game.tracker = :trackerId')
            ->setParameter('trackerId', $trackerId)
            ->groupBy('championId')
            ->orderBy('champCount', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
