<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\AllyRepository;
use App\Traits\PlayersTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllyRepository::class)]
class Ally
{
    use PlayersTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $teamPosition = null;

    #[ORM\Column(nullable: true)]
    private ?bool $selected = null;

    #[ORM\ManyToOne(inversedBy: 'allies')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'allies')]
    private ?DataChampion $dataChampion = null;
}
