<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\DataPerkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataPerkRepository::class)]
class DataPerk
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tooltip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'dataPerk', targetEntity: Perk::class)]
    private Collection $perks;

    public function __construct()
    {
        $this->perks = new ArrayCollection();
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

    public function getTooltip(): ?string
    {
        return $this->tooltip;
    }

    public function setTooltip(?string $tooltip): static
    {
        $this->tooltip = $tooltip;

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
     * @return Collection<int, Perk>
     */
    public function getPerks(): Collection
    {
        return $this->perks;
    }

    public function addPerk(Perk $perk): static
    {
        if (!$this->perks->contains($perk)) {
            $this->perks->add($perk);
            $perk->setDataPerk($this);
        }

        return $this;
    }

    public function removePerk(Perk $perk): static
    {
        if ($this->perks->removeElement($perk)) {
            // set the owning side to null (unless already changed)
            if ($perk->getDataPerk() === $this) {
                $perk->setDataPerk(null);
            }
        }

        return $this;
    }
}
