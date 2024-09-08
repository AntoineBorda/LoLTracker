<?php

namespace App\Entity\App\Tracker;

use App\Entity\Account\User\RiotInfo;
use App\Entity\Account\User\User;
use App\Repository\App\Tracker\TrackerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['riotInfo'], message: 'Tracker déjà présent dans la BDD.', )]
#[ORM\Entity(repositoryClass: TrackerRepository::class)]
class Tracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\OneToMany(mappedBy: 'tracker', cascade: ['persist', 'remove'], targetEntity: Game::class)]
    private Collection $games;

    #[ORM\ManyToOne(inversedBy: 'trackers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'trackers')]
    private ?RiotInfo $riotInfo = null;

    #[ORM\ManyToOne(inversedBy: 'trackers')]
    private ?Player $player = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setTracker($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTracker() === $this) {
                $game->setTracker(null);
            }
        }

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

    public function getRiotInfo(): ?RiotInfo
    {
        return $this->riotInfo;
    }

    public function setRiotInfo(?RiotInfo $riotInfo): static
    {
        $this->riotInfo = $riotInfo;

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
}
