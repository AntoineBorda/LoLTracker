<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\DataSummonerRepository;
use App\Traits\DataItemDataSummonerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataSummonerRepository::class)]
class DataSummoner
{
    use DataItemDataSummonerTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'dataSummoner', targetEntity: Summoner::class)]
    private Collection $summoners;

    public function __construct()
    {
        $this->summoners = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Summoner>
     */
    public function getSummoners(): Collection
    {
        return $this->summoners;
    }

    public function addSummoner(Summoner $summoner): static
    {
        if (!$this->summoners->contains($summoner)) {
            $this->summoners->add($summoner);
            $summoner->setDataSummoner($this);
        }

        return $this;
    }

    public function removeSummoner(Summoner $summoner): static
    {
        if ($this->summoners->removeElement($summoner)) {
            // set the owning side to null (unless already changed)
            if ($summoner->getDataSummoner() === $this) {
                $summoner->setDataSummoner(null);
            }
        }

        return $this;
    }
}
