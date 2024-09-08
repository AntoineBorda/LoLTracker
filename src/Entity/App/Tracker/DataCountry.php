<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\DataCountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataCountryRepository::class)]
class DataCountry
{
    public function __toString(): string
    {
        return $this->common ?? '';
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'string')]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $common = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $official = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $cca2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $flag = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Player::class)]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
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

    public function getCommon(): ?string
    {
        return $this->common;
    }

    public function setCommon(?string $common): static
    {
        $this->common = $common;

        return $this;
    }

    public function getOfficial(): ?string
    {
        return $this->official;
    }

    public function setOfficial(?string $official): static
    {
        $this->official = $official;

        return $this;
    }

    public function getCca2(): ?string
    {
        return $this->cca2;
    }

    public function setCca2(?string $cca2): static
    {
        $this->cca2 = $cca2;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setCountry($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getCountry() === $this) {
                $player->setCountry(null);
            }
        }

        return $this;
    }
}
