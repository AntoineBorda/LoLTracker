<?php

namespace App\Entity\Account\User;

use App\Entity\App\Tracker\Player;
use App\Entity\App\Tracker\Tracker;
use App\Repository\Account\User\RiotInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['gameName', 'tagLine'], message: 'RiotInfo déjà présent dans la BDD.', )]
#[ORM\Entity(repositoryClass: RiotInfoRepository::class)]
class RiotInfo
{
    public function __toString(): string
    {
        return $this->gameName.'#'.$this->tagLine;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gameName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tagLine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $puuid = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $summonerId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountId = null;

    #[ORM\Column(nullable: true)]
    private ?int $profileIconId = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $revisionDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $summonerLevel = null;

    #[ORM\ManyToOne(inversedBy: 'riotInfos')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'riotInfo')]
    private ?Player $player = null;

    #[ORM\OneToMany(mappedBy: 'riotInfo', targetEntity: Tracker::class, cascade: ['remove'])]
    private Collection $trackers;

    public function __construct()
    {
        $this->trackers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(?string $gameName): static
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getTagLine(): ?string
    {
        return $this->tagLine;
    }

    public function setTagLine(?string $tagLine): static
    {
        $this->tagLine = $tagLine;

        return $this;
    }

    public function getPuuid(): ?string
    {
        return $this->puuid;
    }

    public function setPuuid(?string $puuid): static
    {
        $this->puuid = $puuid;

        return $this;
    }

    public function getSummonerId(): ?string
    {
        return $this->summonerId;
    }

    public function setSummonerId(?string $summonerId): static
    {
        $this->summonerId = $summonerId;

        return $this;
    }

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): static
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getProfileIconId(): ?int
    {
        return $this->profileIconId;
    }

    public function setProfileIconId(?int $profileIconId): static
    {
        $this->profileIconId = $profileIconId;

        return $this;
    }

    public function getRevisionDate(): ?string
    {
        return $this->revisionDate;
    }

    public function setRevisionDate(?string $revisionDate): static
    {
        $this->revisionDate = $revisionDate;

        return $this;
    }

    public function getSummonerLevel(): ?int
    {
        return $this->summonerLevel;
    }

    public function setSummonerLevel(?int $summonerLevel): static
    {
        $this->summonerLevel = $summonerLevel;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return Collection<int, Tracker>
     */
    public function getTrackers(): Collection
    {
        return $this->trackers;
    }

    public function addTracker(Tracker $tracker): static
    {
        if (!$this->trackers->contains($tracker)) {
            $this->trackers->add($tracker);
            $tracker->setRiotInfo($this);
        }

        return $this;
    }

    public function removeTracker(Tracker $tracker): static
    {
        if ($this->trackers->removeElement($tracker)) {
            // set the owning side to null (unless already changed)
            if ($tracker->getRiotInfo() === $this) {
                $tracker->setRiotInfo(null);
            }
        }

        return $this;
    }
}
