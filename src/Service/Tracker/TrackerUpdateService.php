<?php

namespace App\Service\Tracker;

use App\Entity\Account\User\RiotInfo;
use App\Entity\App\Tracker\Ally;
use App\Entity\App\Tracker\DataChampion;
use App\Entity\App\Tracker\DataItem;
use App\Entity\App\Tracker\DataPerk;
use App\Entity\App\Tracker\DataQueue;
use App\Entity\App\Tracker\DataSummoner;
use App\Entity\App\Tracker\Game;
use App\Entity\App\Tracker\Item;
use App\Entity\App\Tracker\Opponent;
use App\Entity\App\Tracker\Perk;
use App\Entity\App\Tracker\Pick;
use App\Entity\App\Tracker\Summoner;
use App\Entity\App\Tracker\Tracker;
use App\Service\Data\Riot\RiotLastGameDataService;
use App\Service\Game\ScoreRankService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class TrackerUpdateService
{
    public function __construct(
        private RiotLastGameDataService $riotLastGameDataService,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private ScoreRankService $scoreRankService
    ) {
    }

    public function updateTracker(array $trackers): void
    {
        foreach ($trackers as $tracker) {
            try {
                $timestamp = (new \DateTime())->getTimestamp();
                $riotInfo = $this->entityManager->getRepository(RiotInfo::class)->find($tracker->getRiotInfo());
                $puuid = $riotInfo->getPuuid();
                $data = $this->riotLastGameDataService->getLastGameData($puuid, $timestamp, $tracker->getId());

                if (empty($data['gameData'])) {
                    continue;
                }

                $gameData = $data['gameData'];
                $leagueData = $data['leagueData'];

                $participantData = null;
                $opponentChampions = [];
                $alliesChampions = [];

                // Récupérer les datas du participant
                if (isset($gameData['info']['participants'])) {
                    foreach ($gameData['info']['participants'] as $participant) {
                        if ($participant['puuid'] === $puuid) {
                            $participantData = $participant;
                            break;
                        }
                    }

                    // Déterminer si le participant a gagné ou non
                    $didWin = $participantData['win'] ?? false;

                    // Récupérer les championId et teamPosition des participants ayant l'opposé du résultat du joueur spécifié
                    foreach ($gameData['info']['participants'] as $participant) {
                        if (($participant['win'] ?? false) !== $didWin) {
                            $opponentChampions[] = [
                                'championId' => $participant['championId'] ?? null,
                                'teamPosition' => $participant['teamPosition'] ?? null,
                            ];
                        }
                    }

                    // Récupérer les championId et teamPosition des participants ayant le même résultat que le joueur spécifié
                    foreach ($gameData['info']['participants'] as $participant) {
                        if (($participant['win'] ?? false) === $didWin) {
                            $alliesChampions[] = [
                                'championId' => $participant['championId'] ?? null,
                                'teamPosition' => $participant['teamPosition'] ?? null,
                            ];
                        }
                    }
                    $game = $this->initializeGame($gameData, $participantData, $tracker->getId(), $opponentChampions, $alliesChampions, $leagueData);
                    $this->entityManager->persist($game);
                }
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
        $this->entityManager->flush();
    }

    public function initializeGame($gameData, $participantData, $tracker_id, $opponentChampions, $alliesChampions, $leagueData)
    {
        // GAME
        $game = new Game();

        $game->setTracker($this->entityManager->getRepository(Tracker::class)->find($tracker_id));
        $queueId = $gameData['info']['queueId'] ?? null;
        if (null !== $queueId) {
            $dataQueue = $this->entityManager->getRepository(DataQueue::class)->find($queueId);
            if (null !== $dataQueue) {
                $game->setDataQueue($dataQueue);
            } else {
                $game->setDataQueue(null);
            }
        } else {
            $game->setDataQueue(null);
        }
        $previousGame = $this->entityManager->getRepository(Game::class)->findOneBy(['tracker' => $tracker_id], ['createdAt' => 'DESC']);
        $lpVariation = 0;
        $scoreRank = $this->scoreRankService->rankToNumericValue($leagueData['tier'], $leagueData['rank'], $leagueData['leaguePoints']);
        $game->setScoreRank($scoreRank);
        if ($previousGame) {
            $previousLP = $previousGame->getLeaguePoints();
            $currentLP = $leagueData['leaguePoints'];
            $previousScoreRank = $previousGame->getScoreRank();
            $currentScoreRank = $this->scoreRankService->rankToNumericValue($leagueData['tier'], $leagueData['rank'], $leagueData['leaguePoints']);

            // Promotion vers MASTER
            if ($previousScoreRank < 800 && $currentScoreRank >= 800) {
                $lpVariation = (100 - $previousLP) + $currentLP;
            // Demotion vers DIAMOND
            } elseif ($previousScoreRank >= 800 && $currentScoreRank < 800) {
                $lpVariation = ($currentLP - 100) - $previousLP;
            } else {
                // En dessous de MASTER
                if ($currentScoreRank < 800) {
                    // Promotion
                    if ($currentScoreRank > $previousScoreRank) {
                        $lpVariation = (100 - $previousLP) + $currentLP;
                    // Demotion
                    } elseif ($currentScoreRank < $previousScoreRank) {
                        $lpVariation = ($currentLP - 100) - $previousLP;
                    } else {
                        $lpVariation = $currentLP - $previousLP;
                    }
                } else {
                    // Au dessus de MASTER
                    $lpVariation = $currentLP - $previousLP;
                }
            }
        }
        $game->setLpVar($lpVariation);

        $game->setMatchId($gameData['metadata']['matchId'] ?? null);
        $game->setEndOfGameresult($gameData['info']['endOfGameResult'] ?? null);
        $game->setGameCreation($gameData['info']['gameCreation'] ?? null);
        $game->setGameDuration($gameData['info']['gameDuration'] ?? null);
        $game->setGameMode($gameData['info']['gameMode'] ?? null);
        $game->setGameType($gameData['info']['gameType'] ?? null);
        $game->setGameVersion($gameData['info']['gameVersion'] ?? null);
        $game->setMapId($gameData['info']['mapId'] ?? null);

        $game->setAssists($participantData['assists'] ?? null);
        $game->setBaronKills($participantData['baronKills'] ?? null);
        $game->setBountyLevel($participantData['bountyLevel'] ?? null);
        $game->setChampLevel($participantData['champLevel'] ?? null);
        $game->setDeaths($participantData['deaths'] ?? null);
        $game->setDoubleKills($participantData['doubleKills'] ?? null);
        $game->setEligibleForProgression($participantData['eligibleForProgression'] ?? null);
        $game->setFirstBloodKill($participantData['firstBloodKill'] ?? null);
        $game->setGoldEarned($participantData['goldEarned'] ?? null);
        $game->setKills($participantData['kills'] ?? null);
        $game->setLongestTimeSpentLiving($participantData['longestTimeSpentLiving'] ?? null);
        $game->setNeutralMinionsKilled($participantData['neutralMinionsKilled'] ?? null);
        $game->setPentaKills($participantData['pentaKills'] ?? null);
        $game->setQuadraKills($participantData['quadraKills'] ?? null);
        $game->setTeamPosition($participantData['teamPosition'] ?? null);
        $game->setTimeCCingOthers($participantData['timeCCingOthers'] ?? null);
        $game->setTotalDamageDealtToChampions($participantData['totalDamageDealtToChampions'] ?? null);
        $game->setTotalDamageTaken($participantData['totalDamageTaken'] ?? null);
        $game->setTotalMinionsKilled($participantData['totalMinionsKilled'] ?? null);
        $game->setTotalTimeSpentDead($participantData['totalTimeSpentDead'] ?? null);
        $game->setTripleKills($participantData['tripleKills'] ?? null);
        $game->setVisionScore($participantData['visionScore'] ?? null);
        $game->setWin($participantData['win'] ?? null);

        $game->setBountyGold($participantData['challenges']['bountyGold'] ?? null);
        $game->setDamagePerMinute($participantData['challenges']['damagePerMinute'] ?? null);
        $game->setEarlyLaningPhaseGoldExpAdvantage($participantData['challenges']['earlyLaningPhaseGoldExpAdvantage'] ?? null);
        $game->setFlawlessAces($participantData['challenges']['flawlessAces'] ?? null);
        $game->setGoldPerMinute($participantData['challenges']['goldPerMinute'] ?? null);
        $game->setKda($participantData['challenges']['kda'] ?? null);
        $game->setKillParticipation($participantData['challenges']['killParticipation'] ?? null);
        $game->setLaneMinionsFirst10Minutes($participantData['challenges']['laneMinionsFirst10Minutes'] ?? null);
        $game->setLaningPhaseGoldExpAdvantage($participantData['challenges']['laningPhaseGoldExpAdvantage'] ?? null);
        $game->setMaxCsAdvantageOnLaneOpponent($participantData['challenges']['maxCsAdvantageOnLaneOpponent'] ?? null);
        $game->setMaxLevelLeadLaneOpponent($participantData['challenges']['maxLevelLeadLaneOpponent'] ?? null);
        $game->setSkillshotsDodged($participantData['challenges']['skillshotsDodged'] ?? null);
        $game->setTeamDamagePercentage($participantData['challenges']['teamDamagePercentage'] ?? null);
        $game->setTurretPlatesTaken($participantData['challenges']['turretPlatesTaken'] ?? null);
        $game->setTurretTakedowns($participantData['challenges']['turretTakedowns'] ?? null);
        $game->setVisionScoreAdvantageLaneOpponent($participantData['challenges']['visionScoreAdvantageLaneOpponent'] ?? null);
        $game->setVisionScorePerMinute($participantData['challenges']['visionScorePerMinute'] ?? null);

        $game->setTier($leagueData['tier'] ?? null);
        $game->setRank($leagueData['rank'] ?? null);
        $game->setLeaguePoints($leagueData['leaguePoints'] ?? null);
        $game->setWins($leagueData['wins'] ?? null);
        $game->setLosses($leagueData['losses'] ?? null);
        $game->setVeteran($leagueData['veteran'] ?? null);
        $game->setInactive($leagueData['inactive'] ?? null);
        $game->setFreshBlood($leagueData['freshBlood'] ?? null);
        $game->setHotStreak($leagueData['hotStreak'] ?? null);

        // PICK
        $pick = new Pick();
        $game->addPick($pick);
        $championId = $participantData['championId'] ?? null;
        $championIdId = $this->entityManager->getRepository(DataChampion::class)->find($championId);
        $pick->setdataChampion($championIdId);

        // OPPONENTS
        foreach ($opponentChampions as $opponentChampion) {
            $opponent = new Opponent();
            $game->addOpponent($opponent);
            $championId = $opponentChampion['championId'] ?? null;
            $teamPosition = $opponentChampion['teamPosition'] ?? null;
            $opponentIdId = $this->entityManager->getRepository(DataChampion::class)->find($championId);
            $opponent->setdataChampion($opponentIdId);
            $opponent->setTeamPosition($teamPosition);
        }

        // ALLIES
        foreach ($alliesChampions as $alliesChampion) {
            $ally = new Ally();
            $game->addAlly($ally);
            $championId = $alliesChampion['championId'] ?? null;
            $teamPosition = $alliesChampion['teamPosition'] ?? null;
            $allyIdId = $this->entityManager->getRepository(DataChampion::class)->find($championId);
            $ally->setdataChampion($allyIdId);
            $ally->setTeamPosition($teamPosition);
        }

        // ITEM
        $item = new Item();
        $game->additem($item);
        $item0 = $participantData['item0'] ?? null;
        $item0Name = 'item0';
        $item0Id = $this->entityManager->getRepository(DataItem::class)->find($item0);
        $item->setdataItem($item0Id);
        $item->setName($item0Name);

        $item = new Item();
        $game->additem($item);
        $item1 = $participantData['item1'] ?? null;
        $item1Name = 'item1';
        $item1Id = $this->entityManager->getRepository(DataItem::class)->find($item1);
        $item->setdataItem($item1Id);
        $item->setName($item1Name);

        $item = new Item();
        $game->additem($item);
        $item2 = $participantData['item2'] ?? null;
        $item2Name = 'item2';
        $item2Id = $this->entityManager->getRepository(DataItem::class)->find($item2);
        $item->setdataItem($item2Id);
        $item->setName($item2Name);

        $item = new Item();
        $game->additem($item);
        $item3 = $participantData['item3'] ?? null;
        $item3Name = 'item3';
        $item3Id = $this->entityManager->getRepository(DataItem::class)->find($item3);
        $item->setdataItem($item3Id);
        $item->setName($item3Name);

        $item = new Item();
        $game->additem($item);
        $item4 = $participantData['item4'] ?? null;
        $item4Name = 'item4';
        $item4Id = $this->entityManager->getRepository(DataItem::class)->find($item4);
        $item->setdataItem($item4Id);
        $item->setName($item4Name);

        $item = new Item();
        $game->additem($item);
        $item5 = $participantData['item5'] ?? null;
        $item5Name = 'item5';
        $item5Id = $this->entityManager->getRepository(DataItem::class)->find($item5);
        $item->setdataItem($item5Id);
        $item->setName($item5Name);

        $item = new Item();
        $game->additem($item);
        $item6 = $participantData['item6'] ?? null;
        $item6Name = 'item6';
        $item6Id = $this->entityManager->getRepository(DataItem::class)->find($item6);
        $item->setdataItem($item6Id);
        $item->setName($item6Name);

        // SUMMONER
        $summoner = new Summoner();
        $game->addSummoner($summoner);
        $summoner1Id = $participantData['summoner1Id'] ?? null;
        $summoner1Name = 'summoner1Id';
        $summoner1IdId = $this->entityManager->getRepository(DataSummoner::class)->find($summoner1Id);
        $summoner->setdataSummoner($summoner1IdId);
        $summoner->setName($summoner1Name);

        $summoner = new Summoner();
        $game->addSummoner($summoner);
        $summoner2Id = $participantData['summoner2Id'] ?? null;
        $summoner2Name = 'summoner2Id';
        $summoner2IdId = $this->entityManager->getRepository(DataSummoner::class)->find($summoner2Id);
        $summoner->setdataSummoner($summoner2IdId);
        $summoner->setName($summoner2Name);

        // PERK
        $perk = new Perk();
        $game->addPerk($perk);
        $primaryStyle = $participantData['perks']['styles']['0']['style'] ?? null;
        $primaryStyleName = 'primaryStyle';
        $primaryStyleId = $this->entityManager->getRepository(DataPerk::class)->find($primaryStyle);
        $perk->setdataPerk($primaryStyleId);
        $perk->setName($primaryStyleName);

        $perk = new Perk();
        $game->addPerk($perk);
        $primaryPerk0 = $participantData['perks']['styles']['0']['selections']['0']['perk'] ?? null;
        $primaryPerk0Name = 'primaryPerk0';
        $primaryPerk0Id = $this->entityManager->getRepository(DataPerk::class)->find($primaryPerk0);
        $perk->setdataPerk($primaryPerk0Id);
        $perk->setName($primaryPerk0Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $primaryPerk1 = $participantData['perks']['styles']['0']['selections']['1']['perk'] ?? null;
        $primaryPerk1Name = 'primaryPerk1';
        $primaryPerk1Id = $this->entityManager->getRepository(DataPerk::class)->find($primaryPerk1);
        $perk->setdataPerk($primaryPerk1Id);
        $perk->setName($primaryPerk1Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $primaryPerk2 = $participantData['perks']['styles']['0']['selections']['2']['perk'] ?? null;
        $primaryPerk2Name = 'primaryPerk2';
        $primaryPerk2Id = $this->entityManager->getRepository(DataPerk::class)->find($primaryPerk2);
        $perk->setdataPerk($primaryPerk2Id);
        $perk->setName($primaryPerk2Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $primaryPerk3 = $participantData['perks']['styles']['0']['selections']['3']['perk'] ?? null;
        $primaryPerk3Name = 'primaryPerk3';
        $primaryPerk3Id = $this->entityManager->getRepository(DataPerk::class)->find($primaryPerk3);
        $perk->setdataPerk($primaryPerk3Id);
        $perk->setName($primaryPerk3Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $subStyle = $participantData['perks']['styles']['1']['style'] ?? null;
        $subStyleName = 'subStyle';
        $subStyleId = $this->entityManager->getRepository(DataPerk::class)->find($subStyle);
        $perk->setdataPerk($subStyleId);
        $perk->setName($subStyleName);

        $perk = new Perk();
        $game->addPerk($perk);
        $subPerk0 = $participantData['perks']['styles']['1']['selections']['0']['perk'] ?? null;
        $subPerk0Name = 'subPerk0';
        $subPerk0Id = $this->entityManager->getRepository(DataPerk::class)->find($subPerk0);
        $perk->setdataPerk($subPerk0Id);
        $perk->setName($subPerk0Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $subPerk1 = $participantData['perks']['styles']['1']['selections']['1']['perk'] ?? null;
        $subPerk1Name = 'subPerk1';
        $subPerk1Id = $this->entityManager->getRepository(DataPerk::class)->find($subPerk1);
        $perk->setdataPerk($subPerk1Id);
        $perk->setName($subPerk1Name);

        $perk = new Perk();
        $game->addPerk($perk);
        $statPerksDefense = $participantData['perks']['statPerks']['defense'] ?? null;
        $statPerksDefenseName = 'statPerksDefense';
        $statPerksDefenseId = $this->entityManager->getRepository(DataPerk::class)->find($statPerksDefense);
        $perk->setdataPerk($statPerksDefenseId);
        $perk->setName($statPerksDefenseName);

        $perk = new Perk();
        $game->addPerk($perk);
        $statPerksFlex = $participantData['perks']['statPerks']['flex'] ?? null;
        $statPerksFlexName = 'statPerksFlex';
        $statPerksFlexId = $this->entityManager->getRepository(DataPerk::class)->find($statPerksFlex);
        $perk->setdataPerk($statPerksFlexId);
        $perk->setName($statPerksFlexName);

        $perk = new Perk();
        $game->addPerk($perk);
        $statPerksOffense = $participantData['perks']['statPerks']['offense'] ?? null;
        $statPerksOffenseName = 'statPerksOffense';
        $statPerksOffenseId = $this->entityManager->getRepository(DataPerk::class)->find($statPerksOffense);
        $perk->setdataPerk($statPerksOffenseId);
        $perk->setName($statPerksOffenseName);

        return $game;
    }
}
