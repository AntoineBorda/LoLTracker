<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\SummonerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummonerRepository::class)]
class Summoner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'summoners')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'summoners')]
    private ?DataSummoner $dataSummoner = null;

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

    public function getDataSummoner(): ?DataSummoner
    {
        return $this->dataSummoner;
    }

    public function setDataSummoner(?DataSummoner $dataSummoner): static
    {
        $this->dataSummoner = $dataSummoner;

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
