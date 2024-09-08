<?php

namespace App\Entity\App\Tracker;

use App\Entity\Account\User\RiotInfo;
use App\Entity\Account\User\User;
use App\Repository\App\Tracker\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['summonerName'], message: 'Joueur déjà présent dans la BDD.', )]
#[UniqueEntity(fields: ['twitch'], message: 'Twitch déjà présent dans la BDD.', )]
#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    public function __toString(): string
    {
        return $this->summonerName ?? '';
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'string', options: ['collation' => 'utf8_bin'])]
    private ?string $id = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true, unique: true, options: ['unsigned' => true])]
    private ?string $idRiot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $summonerName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $role = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitch = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?DataCountry $country = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Tracker::class)]
    private Collection $trackers;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: RiotInfo::class)]
    private Collection $riotInfo;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Team::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: League::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $leagues;

    public function __construct()
    {
        $this->trackers = new ArrayCollection();
        $this->riotInfo = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->leagues = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdRiot(): ?string
    {
        return $this->idRiot;
    }

    public function setIdRiot(?string $idRiot): static
    {
        $this->idRiot = $idRiot;

        return $this;
    }

    public function getSummonerName(): ?string
    {
        return $this->summonerName;
    }

    public function setSummonerName(?string $summonerName): static
    {
        $this->summonerName = $summonerName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getTwitch(): ?string
    {
        return $this->twitch;
    }

    public function setTwitch(?string $twitch): static
    {
        $this->twitch = $twitch;

        return $this;
    }

    public function getCountry(): ?DataCountry
    {
        return $this->country;
    }

    public function setCountry(?DataCountry $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

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
            $tracker->setPlayer($this);
        }

        return $this;
    }

    public function removeTracker(Tracker $tracker): static
    {
        if ($this->trackers->removeElement($tracker)) {
            // set the owning side to null (unless already changed)
            if ($tracker->getPlayer() === $this) {
                $tracker->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RiotInfo>
     */
    public function getRiotInfo(): Collection
    {
        return $this->riotInfo;
    }

    public function addRiotInfo(RiotInfo $riotInfo): static
    {
        if (!$this->riotInfo->contains($riotInfo)) {
            $this->riotInfo->add($riotInfo);
            $riotInfo->setPlayer($this);
        }

        return $this;
    }

    public function removeRiotInfo(RiotInfo $riotInfo): static
    {
        if ($this->riotInfo->removeElement($riotInfo)) {
            // set the owning side to null (unless already changed)
            if ($riotInfo->getPlayer() === $this) {
                $riotInfo->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setPlayer($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getPlayer() === $this) {
                $team->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): static
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues->add($league);
            $league->setPlayer($this);
        }

        return $this;
    }

    public function removeLeague(League $league): static
    {
        if ($this->leagues->removeElement($league)) {
            // set the owning side to null (unless already changed)
            if ($league->getPlayer() === $this) {
                $league->setPlayer(null);
            }
        }

        return $this;
    }
}
