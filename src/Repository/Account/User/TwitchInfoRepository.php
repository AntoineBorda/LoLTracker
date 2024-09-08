<?php

namespace App\Repository\Account\User;

use App\Entity\Account\User\TwitchInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitchInfo>
 *
 * @method TwitchInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwitchInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwitchInfo[]    findAll()
 * @method TwitchInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitchInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitchInfo::class);
    }

    //    /**
    //     * @return TwitchInfo[] Returns an array of TwitchInfo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TwitchInfo
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
