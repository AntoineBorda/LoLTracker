<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\PerkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerkRepository::class)]
class Perk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'perks')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'perks')]
    private ?DataPerk $dataPerk = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getDataPerk(): ?DataPerk
    {
        return $this->dataPerk;
    }

    public function setDataPerk(?DataPerk $dataPerk): static
    {
        $this->dataPerk = $dataPerk;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
