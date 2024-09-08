<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\PickRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PickRepository::class)]
class Pick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'picks', )]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'picks')]
    private ?DataChampion $dataChampion = null;

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

    public function getdataChampion(): ?DataChampion
    {
        return $this->dataChampion;
    }

    public function setdataChampion(?DataChampion $dataChampion): static
    {
        $this->dataChampion = $dataChampion;

        return $this;
    }
}
