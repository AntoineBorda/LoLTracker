<?php

namespace App\Traits;

use App\Entity\App\Tracker\DataChampion;
use App\Entity\App\Tracker\Game;

trait PlayersTrait
{
    public function getId(): ?int
    {
        return $this->id;
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

    public function isSelected(): ?bool
    {
        return $this->selected;
    }

    public function setSelected(?bool $selected): static
    {
        $this->selected = $selected;

        return $this;
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

    public function getDataChampion(): ?DataChampion
    {
        return $this->dataChampion;
    }

    public function setDataChampion(?DataChampion $dataChampion): static
    {
        $this->dataChampion = $dataChampion;

        return $this;
    }
}
