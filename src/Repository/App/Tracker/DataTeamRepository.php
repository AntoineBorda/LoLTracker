<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataTeam>
 *
 * @method DataTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataTeam[]    findAll()
 * @method DataTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTeam::class);
    }

    //    /**
    //     * @return DataTeam[] Returns an array of DataTeam objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DataTeam
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
