<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\LeagueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeagueRepository::class)]
class League
{
    public function __toString(): string
    {
        return $this->getDataLeague()->getName();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'leagues', targetEntity: Player::class)]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'leagues', targetEntity: DataLeague::class)]
    private ?DataLeague $dataLeague = null;

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

    public function getDataLeague(): ?DataLeague
    {
        return $this->dataLeague;
    }

    public function setDataLeague(?DataLeague $dataLeague): static
    {
        $this->dataLeague = $dataLeague;

        return $this;
    }
}
