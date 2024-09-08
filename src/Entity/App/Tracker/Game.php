<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $lpvar = null;

    #[ORM\Column(nullable: true)]
    private ?int $scoreRank = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $matchId = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $endOfGameResult = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $gameCreation = null;

    #[ORM\Column(nullable: true)]
    private ?int $gameDuration = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $gameMode = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $gameType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $gameVersion = null;

    #[ORM\Column(nullable: true)]
    private ?int $mapId = null;

    #[ORM\Column(nullable: true)]
    private ?int $assists = null;

    #[ORM\Column(nullable: true)]
    private ?int $baronKills = null;

    #[ORM\Column(nullable: true)]
    private ?int $bountyLevel = null;

    #[ORM\Column(nullable: true)]
    private ?int $champLevel = null;

    #[ORM\Column(nullable: true)]
    private ?int $deaths = null;

    #[ORM\Column(nullable: true)]
    private ?int $doubleKills = null;

    #[ORM\Column(nullable: true)]
    private ?bool $eligibleForProgression = null;

    #[ORM\Column(nullable: true)]
    private ?bool $firstBloodKill = null;

    #[ORM\Column(nullable: true)]
    private ?int $goldEarned = null;

    #[ORM\Column(nullable: true)]
    private ?int $kills = null;

    #[ORM\Column(nullable: true)]
    private ?int $longestTimeSpentLiving = null;

    #[ORM\Column(nullable: true)]
    private ?int $neutralMinionsKilled = null;

    #[ORM\Column(nullable: true)]
    private ?int $pentaKills = null;

    #[ORM\Column(nullable: true)]
    private ?int $quadraKills = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $teamPosition = null;

    #[ORM\Column(nullable: true)]
    private ?int $timeCCingOthers = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalDamageDealtToChampions = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalDamageTaken = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalMinionsKilled = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalTimeSpentDead = null;

    #[ORM\Column(nullable: true)]
    private ?int $tripleKills = null;

    #[ORM\Column(nullable: true)]
    private ?int $visionScore = null;

    #[ORM\Column(nullable: true)]
    private ?bool $win = null;

    #[ORM\Column(nullable: true)]
    private ?int $bountyGold = null;

    #[ORM\Column(nullable: true)]
    private ?float $damagePerMinute = null;

    #[ORM\Column(nullable: true)]
    private ?int $earlyLaningPhaseGoldExpAdvantage = null;

    #[ORM\Column(nullable: true)]
    private ?int $flawlessAces = null;

    #[ORM\Column(nullable: true)]
    private ?float $goldPerMinute = null;

    #[ORM\Column(nullable: true)]
    private ?float $kda = null;

    #[ORM\Column(nullable: true)]
    private ?float $killParticipation = null;

    #[ORM\Column(nullable: true)]
    private ?int $laneMinionsFirst10Minutes = null;

    #[ORM\Column(nullable: true)]
    private ?int $laningPhaseGoldExpAdvantage = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxCsAdvantageOnLaneOpponent = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxLevelLeadLaneOpponent = null;

    #[ORM\Column(nullable: true)]
    private ?int $skillshotsDodged = null;

    #[ORM\Column(nullable: true)]
    private ?float $teamDamagePercentage = null;

    #[ORM\Column(nullable: true)]
    private ?int $turretPlatesTaken = null;

    #[ORM\Column(nullable: true)]
    private ?int $turretTakedowns = null;

    #[ORM\Column(nullable: true)]
    private ?float $visionScoreAdvantageLaneOpponent = null;

    #[ORM\Column(nullable: true)]
    private ?float $visionScorePerMinute = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $tier = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $rank = null;

    #[ORM\Column(nullable: true)]
    private ?int $leaguePoints = null;

    #[ORM\Column(nullable: true)]
    private ?int $wins = null;

    #[ORM\Column(nullable: true)]
    private ?int $losses = null;

    #[ORM\Column(nullable: true)]
    private ?bool $veteran = null;

    #[ORM\Column(nullable: true)]
    private ?bool $inactive = null;

    #[ORM\Column(nullable: true)]
    private ?bool $freshBlood = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hotStreak = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Tracker $tracker = null;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Pick::class)]
    private Collection $picks;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Summoner::class)]
    private Collection $summoners;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Item::class)]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Perk::class)]
    private Collection $perks;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Opponent::class)]
    private Collection $opponents;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?DataQueue $dataQueue = null;

    #[ORM\OneToMany(mappedBy: 'game', cascade: ['persist', 'remove'], targetEntity: Ally::class)]
    private Collection $allies;

    public function __construct()
    {
        $this->picks = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->summoners = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->perks = new ArrayCollection();
        $this->opponents = new ArrayCollection();
        $this->allies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLpvar(): ?int
    {
        return $this->lpvar;
    }

    public function setLpvar(?int $lpvar): static
    {
        $this->lpvar = $lpvar;

        return $this;
    }

    public function getScoreRank(): ?int
    {
        return $this->scoreRank;
    }

    public function setScoreRank(?int $scoreRank): static
    {
        $this->scoreRank = $scoreRank;

        return $this;
    }

    public function getMatchId(): ?string
    {
        return $this->matchId;
    }

    public function setMatchId(?string $matchId): static
    {
        $this->matchId = $matchId;

        return $this;
    }

    public function getEndOfGameResult(): ?string
    {
        return $this->endOfGameResult;
    }

    public function setEndOfGameResult(?string $endOfGameResult): static
    {
        $this->endOfGameResult = $endOfGameResult;

        return $this;
    }

    public function getGameCreation(): ?string
    {
        return $this->gameCreation;
    }

    public function setGameCreation(?string $gameCreation): static
    {
        $this->gameCreation = $gameCreation;

        return $this;
    }

    public function getGameDuration(): ?int
    {
        return $this->gameDuration;
    }

    public function setGameDuration(?int $gameDuration): static
    {
        $this->gameDuration = $gameDuration;

        return $this;
    }

    public function getGameMode(): ?string
    {
        return $this->gameMode;
    }

    public function setGameMode(?string $gameMode): static
    {
        $this->gameMode = $gameMode;

        return $this;
    }

    public function getGameType(): ?string
    {
        return $this->gameType;
    }

    public function setGameType(?string $gameType): static
    {
        $this->gameType = $gameType;

        return $this;
    }

    public function getGameVersion(): ?string
    {
        return $this->gameVersion;
    }

    public function setGameVersion(?string $gameVersion): static
    {
        $this->gameVersion = $gameVersion;

        return $this;
    }

    public function getMapId(): ?int
    {
        return $this->mapId;
    }

    public function setMapid(?int $mapId): static
    {
        $this->mapId = $mapId;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(?int $assists): static
    {
        $this->assists = $assists;

        return $this;
    }

    public function getBaronKills(): ?int
    {
        return $this->baronKills;
    }

    public function setBaronKills(?int $baronKills): static
    {
        $this->baronKills = $baronKills;

        return $this;
    }

    public function getBountyLevel(): ?int
    {
        return $this->bountyLevel;
    }

    public function setBountyLevel(?int $bountyLevel): static
    {
        $this->bountyLevel = $bountyLevel;

        return $this;
    }

    public function getChampLevel(): ?int
    {
        return $this->champLevel;
    }

    public function setChampLevel(?int $champLevel): static
    {
        $this->champLevel = $champLevel;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(?int $deaths): static
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getDoubleKills(): ?int
    {
        return $this->doubleKills;
    }

    public function setDoubleKills(?int $doubleKills): static
    {
        $this->doubleKills = $doubleKills;

        return $this;
    }

    public function isEligibleForProgression(): ?bool
    {
        return $this->eligibleForProgression;
    }

    public function setEligibleForProgression(?bool $eligibleForProgression): static
    {
        $this->eligibleForProgression = $eligibleForProgression;

        return $this;
    }

    public function isFirstBloodKill(): ?bool
    {
        return $this->firstBloodKill;
    }

    public function setFirstBloodKill(?bool $firstBloodKill): static
    {
        $this->firstBloodKill = $firstBloodKill;

        return $this;
    }

    public function getGoldEarned(): ?int
    {
        return $this->goldEarned;
    }

    public function setGoldEarned(?int $goldEarned): static
    {
        $this->goldEarned = $goldEarned;

        return $this;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(?int $kills): static
    {
        $this->kills = $kills;

        return $this;
    }

    public function getLongestTimeSpentLiving(): ?int
    {
        return $this->longestTimeSpentLiving;
    }

    public function setLongestTimeSpentLiving(?int $longestTimeSpentLiving): static
    {
        $this->longestTimeSpentLiving = $longestTimeSpentLiving;

        return $this;
    }

    public function getNeutralMinionsKilled(): ?int
    {
        return $this->neutralMinionsKilled;
    }

    public function setNeutralMinionsKilled(?int $neutralMinionsKilled): static
    {
        $this->neutralMinionsKilled = $neutralMinionsKilled;

        return $this;
    }

    public function getPentaKills(): ?int
    {
        return $this->pentaKills;
    }

    public function setPentaKills(?int $pentaKills): static
    {
        $this->pentaKills = $pentaKills;

        return $this;
    }

    public function getQuadraKills(): ?int
    {
        return $this->quadraKills;
    }

    public function setQuadraKills(?int $quadraKills): static
    {
        $this->quadraKills = $quadraKills;

        return $this;
    }

    public function getTeamPosition(): ?string
    {
        return $this->teamPosition;
    }

    public function setTeamPosition(?string $teamPosition): static
    {
        $this->teamPosition = $teamPosition;

        return $this;
    }

    public function getTimeCCingOthers(): ?int
    {
        return $this->timeCCingOthers;
    }

    public function setTimeCCingOthers(?int $timeCCingOthers): static
    {
        $this->timeCCingOthers = $timeCCingOthers;

        return $this;
    }

    public function getTotalDamageDealtToChampions(): ?int
    {
        return $this->totalDamageDealtToChampions;
    }

    public function setTotalDamageDealtToChampions(?int $totalDamageDealtToChampions): static
    {
        $this->totalDamageDealtToChampions = $totalDamageDealtToChampions;

        return $this;
    }

    public function getTotalDamageTaken(): ?int
    {
        return $this->totalDamageTaken;
    }

    public function setTotalDamageTaken(?int $totalDamageTaken): static
    {
        $this->totalDamageTaken = $totalDamageTaken;

        return $this;
    }

    public function getTotalMinionsKilled(): ?int
    {
        return $this->totalMinionsKilled;
    }

    public function setTotalMinionsKilled(?int $totalMinionsKilled): static
    {
        $this->totalMinionsKilled = $totalMinionsKilled;

        return $this;
    }

    public function getTotalTimeSpentDead(): ?int
    {
        return $this->totalTimeSpentDead;
    }

    public function setTotalTimeSpentDead(?int $totalTimeSpentDead): static
    {
        $this->totalTimeSpentDead = $totalTimeSpentDead;

        return $this;
    }

    public function getTripleKills(): ?int
    {
        return $this->tripleKills;
    }

    public function setTripleKills(?int $tripleKills): static
    {
        $this->tripleKills = $tripleKills;

        return $this;
    }

    public function getVisionScore(): ?int
    {
        return $this->visionScore;
    }

    public function setVisionScore(?int $visionScore): static
    {
        $this->visionScore = $visionScore;

        return $this;
    }

    public function isWin(): ?bool
    {
        return $this->win;
    }

    public function setWin(?bool $win): static
    {
        $this->win = $win;

        return $this;
    }

    public function getBountyGold(): ?int
    {
        return $this->bountyGold;
    }

    public function setBountyGold(?int $bountyGold): static
    {
        $this->bountyGold = $bountyGold;

        return $this;
    }

    public function getDamagePerMinute(): ?float
    {
        return $this->damagePerMinute;
    }

    public function setDamagePerMinute(?float $damagePerMinute): static
    {
        $this->damagePerMinute = $damagePerMinute;

        return $this;
    }

    public function getEarlyLaningPhaseGoldExpAdvantage(): ?int
    {
        return $this->earlyLaningPhaseGoldExpAdvantage;
    }

    public function setEarlyLaningPhaseGoldExpAdvantage(?int $earlyLaningPhaseGoldExpAdvantage): static
    {
        $this->earlyLaningPhaseGoldExpAdvantage = $earlyLaningPhaseGoldExpAdvantage;

        return $this;
    }

    public function getFlawlessAces(): ?int
    {
        return $this->flawlessAces;
    }

    public function setFlawlessAces(?int $flawlessAces): static
    {
        $this->flawlessAces = $flawlessAces;

        return $this;
    }

    public function getGoldPerMinute(): ?float
    {
        return $this->goldPerMinute;
    }

    public function setGoldPerMinute(?float $goldPerMinute): static
    {
        $this->goldPerMinute = $goldPerMinute;

        return $this;
    }

    public function getKda(): ?float
    {
        return $this->kda;
    }

    public function setKda(?float $kda): static
    {
        $this->kda = $kda;

        return $this;
    }

    public function getKillParticipation(): ?float
    {
        return $this->killParticipation;
    }

    public function setKillParticipation(?float $killParticipation): static
    {
        $this->killParticipation = $killParticipation;

        return $this;
    }

    public function getLaneMinionsFirst10Minutes(): ?int
    {
        return $this->laneMinionsFirst10Minutes;
    }

    public function setLaneMinionsFirst10Minutes(?int $laneMinionsFirst10Minutes): static
    {
        $this->laneMinionsFirst10Minutes = $laneMinionsFirst10Minutes;

        return $this;
    }

    public function getLaningPhaseGoldExpAdvantage(): ?int
    {
        return $this->laningPhaseGoldExpAdvantage;
    }

    public function setLaningPhaseGoldExpAdvantage(?int $laningPhaseGoldExpAdvantage): static
    {
        $this->laningPhaseGoldExpAdvantage = $laningPhaseGoldExpAdvantage;

        return $this;
    }

    public function getMaxCsAdvantageOnLaneOpponent(): ?int
    {
        return $this->maxCsAdvantageOnLaneOpponent;
    }

    public function setMaxCsAdvantageOnLaneOpponent(?int $maxCsAdvantageOnLaneOpponent): static
    {
        $this->maxCsAdvantageOnLaneOpponent = $maxCsAdvantageOnLaneOpponent;

        return $this;
    }

    public function getMaxLevelLeadLaneOpponent(): ?int
    {
        return $this->maxLevelLeadLaneOpponent;
    }

    public function setMaxLevelLeadLaneOpponent(?int $maxLevelLeadLaneOpponent): static
    {
        $this->maxLevelLeadLaneOpponent = $maxLevelLeadLaneOpponent;

        return $this;
    }

    public function getSkillshotsDodged(): ?int
    {
        return $this->skillshotsDodged;
    }

    public function setSkillshotsDodged(?int $skillshotsDodged): static
    {
        $this->skillshotsDodged = $skillshotsDodged;

        return $this;
    }

    public function getTeamDamagePercentage(): ?float
    {
        return $this->teamDamagePercentage;
    }

    public function setTeamDamagePercentage(?float $teamDamagePercentage): static
    {
        $this->teamDamagePercentage = $teamDamagePercentage;

        return $this;
    }

    public function getTurretPlatesTaken(): ?int
    {
        return $this->turretPlatesTaken;
    }

    public function setTurretPlatesTaken(?int $turretPlatesTaken): static
    {
        $this->turretPlatesTaken = $turretPlatesTaken;

        return $this;
    }

    public function getTurretTakedowns(): ?int
    {
        return $this->turretTakedowns;
    }

    public function setTurretTakedowns(?int $turretTakedowns): static
    {
        $this->turretTakedowns = $turretTakedowns;

        return $this;
    }

    public function getVisionScoreAdvantageLaneOpponent(): ?float
    {
        return $this->visionScoreAdvantageLaneOpponent;
    }

    public function setVisionScoreAdvantageLaneOpponent(?float $visionScoreAdvantageLaneOpponent): static
    {
        $this->visionScoreAdvantageLaneOpponent = $visionScoreAdvantageLaneOpponent;

        return $this;
    }

    public function getVisionScorePerMinute(): ?float
    {
        return $this->visionScorePerMinute;
    }

    public function setVisionScorePerMinute(?float $visionScorePerMinute): static
    {
        $this->visionScorePerMinute = $visionScorePerMinute;

        return $this;
    }

    public function getTier(): ?string
    {
        return $this->tier;
    }

    public function setTier(?string $tier): static
    {
        $this->tier = $tier;

        return $this;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(?string $rank): static
    {
        $this->rank = $rank;

        return $this;
    }

    public function getLeaguePoints(): ?int
    {
        return $this->leaguePoints;
    }

    public function setLeaguePoints(?int $leaguePoints): static
    {
        $this->leaguePoints = $leaguePoints;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(?int $wins): static
    {
        $this->wins = $wins;

        return $this;
    }

    public function getLosses(): ?int
    {
        return $this->losses;
    }

    public function setLosses(?int $losses): static
    {
        $this->losses = $losses;

        return $this;
    }

    public function isVeteran(): ?bool
    {
        return $this->veteran;
    }

    public function setVeteran(?bool $veteran): static
    {
        $this->veteran = $veteran;

        return $this;
    }

    public function isInactive(): ?bool
    {
        return $this->inactive;
    }

    public function setInactive(?bool $inactive): static
    {
        $this->inactive = $inactive;

        return $this;
    }

    public function isFreshBlood(): ?bool
    {
        return $this->freshBlood;
    }

    public function setFreshBlood(?bool $freshBlood): static
    {
        $this->freshBlood = $freshBlood;

        return $this;
    }

    public function isHotStreak(): ?bool
    {
        return $this->hotStreak;
    }

    public function setHotStreak(?bool $hotStreak): static
    {
        $this->hotStreak = $hotStreak;

        return $this;
    }

    public function getTracker(): ?Tracker
    {
        return $this->tracker;
    }

    public function setTracker(?Tracker $tracker): static
    {
        $this->tracker = $tracker;

        return $this;
    }

    /**
     * @return Collection<int, Pick>
     */
    public function getPicks(): Collection
    {
        return $this->picks;
    }

    public function addPick(Pick $pick): static
    {
        if (!$this->picks->contains($pick)) {
            $this->picks->add($pick);
            $pick->setGame($this);
        }

        return $this;
    }

    public function removePick(Pick $pick): static
    {
        if ($this->picks->removeElement($pick)) {
            // set the owning side to null (unless already changed)
            if ($pick->getGame() === $this) {
                $pick->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Summoner>
     */
    public function getSummoners(): Collection
    {
        return $this->summoners;
    }

    public function addSummoner(Summoner $summoner): static
    {
        if (!$this->summoners->contains($summoner)) {
            $this->summoners->add($summoner);
            $summoner->setGame($this);
        }

        return $this;
    }

    public function removeSummoner(Summoner $summoner): static
    {
        if ($this->summoners->removeElement($summoner)) {
            // set the owning side to null (unless already changed)
            if ($summoner->getGame() === $this) {
                $summoner->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setGame($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getGame() === $this) {
                $item->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Perk>
     */
    public function getPerks(): Collection
    {
        return $this->perks;
    }

    public function addPerk(Perk $perk): static
    {
        if (!$this->perks->contains($perk)) {
            $this->perks->add($perk);
            $perk->setGame($this);
        }

        return $this;
    }

    public function removePerk(Perk $perk): static
    {
        if ($this->perks->removeElement($perk)) {
            // set the owning side to null (unless already changed)
            if ($perk->getGame() === $this) {
                $perk->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Opponent>
     */
    public function getOpponents(): Collection
    {
        return $this->opponents;
    }

    public function addOpponent(Opponent $opponent): static
    {
        if (!$this->opponents->contains($opponent)) {
            $this->opponents->add($opponent);
            $opponent->setGame($this);
        }

        return $this;
    }

    public function removeOpponent(Opponent $opponent): static
    {
        if ($this->opponents->removeElement($opponent)) {
            // set the owning side to null (unless already changed)
            if ($opponent->getGame() === $this) {
                $opponent->setGame(null);
            }
        }

        return $this;
    }

    public function getDataQueue(): ?DataQueue
    {
        return $this->dataQueue;
    }

    public function setDataQueue(?DataQueue $dataQueue): static
    {
        $this->dataQueue = $dataQueue;

        return $this;
    }

    /**
     * @return Collection<int, Ally>
     */
    public function getAllies(): Collection
    {
        return $this->allies;
    }

    public function addAlly(Ally $ally): static
    {
        if (!$this->allies->contains($ally)) {
            $this->allies->add($ally);
            $ally->setGame($this);
        }

        return $this;
    }

    public function removeAlly(Ally $ally): static
    {
        if ($this->allies->removeElement($ally)) {
            // set the owning side to null (unless already changed)
            if ($ally->getGame() === $this) {
                $ally->setGame(null);
            }
        }

        return $this;
    }
}
