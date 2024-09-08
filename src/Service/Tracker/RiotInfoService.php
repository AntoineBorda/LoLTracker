<?php

namespace App\Service\Tracker;

use App\Entity\Account\User\RiotInfo;
use App\Service\Api\Riot\RiotApiService;
use Doctrine\ORM\EntityManagerInterface;

class RiotInfoService
{
    public function __construct(
        private RiotApiService $riotApiService,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function updateRiotInfo(RiotInfo $riotInfo): void
    {
        $puuid = $this->riotApiService->getPuuidByRiotId($riotInfo->getGamename(), $riotInfo->getTagline());
        $summonerData = $this->riotApiService->getSummonerDataByPuuid($puuid['puuid']);

        $riotInfo->setPuuid($puuid['puuid']);
        $riotInfo->setSummonerId($summonerData['id']);
        $riotInfo->setAccountId($summonerData['accountId']);
        $riotInfo->setProfileIconId($summonerData['profileIconId']);
        $riotInfo->setRevisionDate($summonerData['revisionDate']);
        $riotInfo->setSummonerLevel($summonerData['summonerLevel']);

        $this->entityManager->flush();
    }
}
