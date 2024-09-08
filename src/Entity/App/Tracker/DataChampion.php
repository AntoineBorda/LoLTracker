<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\DataChampionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataChampionRepository::class)]
class DataChampion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'dataChampion', targetEntity: Pick::class)]
    private Collection $picks;

    #[ORM\OneToMany(mappedBy: 'dataChampion', targetEntity: Opponent::class)]
    private Collection $opponents;

    #[ORM\OneToMany(mappedBy: 'dataChampion', targetEntity: Ally::class)]
    private Collection $allies;

    public function __construct()
    {
        $this->picks = new ArrayCollection();
        $this->opponents = new ArrayCollection();
        $this->allies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Pick>
     */
    public function getPicks(): Collection
    {
        return $this->picks;
    }

    public function addPick(Pick $pick): static
    {
        if (!$this->picks->contains($pick)) {
            $this->picks->add($pick);
            $pick->setdataChampion($this);
        }

        return $this;
    }

    public function removePick(Pick $pick): static
    {
        if ($this->picks->removeElement($pick)) {
            // set the owning side to null (unless already changed)
            if ($pick->getdataChampion() === $this) {
                $pick->setdataChampion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Opponent>
     */
    public function getOpponents(): Collection
    {
        return $this->opponents;
    }

    public function addOpponent(Opponent $opponent): static
    {
        if (!$this->opponents->contains($opponent)) {
            $this->opponents->add($opponent);
            $opponent->setDataChampion($this);
        }

        return $this;
    }

    public function removeOpponent(Opponent $opponent): static
    {
        if ($this->opponents->removeElement($opponent)) {
            // set the owning side to null (unless already changed)
            if ($opponent->getDataChampion() === $this) {
                $opponent->setDataChampion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ally>
     */
    public function getAllies(): Collection
    {
        return $this->allies;
    }

    public function addAlly(Ally $ally): static
    {
        if (!$this->allies->contains($ally)) {
            $this->allies->add($ally);
            $ally->setDataChampion($this);
        }

        return $this;
    }

    public function removeAlly(Ally $ally): static
    {
        if ($this->allies->removeElement($ally)) {
            // set the owning side to null (unless already changed)
            if ($ally->getDataChampion() === $this) {
                $ally->setDataChampion(null);
            }
        }

        return $this;
    }
}
