<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\TeamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    public function __toString(): string
    {
        return $this->getDataTeam()->getName();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teams', targetEntity: Player::class)]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'teams', targetEntity: DataTeam::class)]
    private ?DataTeam $dataTeam = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDataTeam(): ?DataTeam
    {
        return $this->dataTeam;
    }

    public function setDataTeam(?DataTeam $dataTeam): static
    {
        $this->dataTeam = $dataTeam;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
