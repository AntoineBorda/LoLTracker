<?php

namespace App\Repository\Account\User;

use App\Entity\Account\User\RiotInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RiotInfo>
 *
 * @method RiotInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method RiotInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method RiotInfo[]    findAll()
 * @method RiotInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiotInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RiotInfo::class);
    }
}
