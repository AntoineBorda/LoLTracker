<?php

namespace App\Entity\App\Tracker;

use App\Repository\App\Tracker\DataTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataTeamRepository::class)]
class DataTeam
{
    public function __toString(): string
    {
        return $this->name ?? '';
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alternativeImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $homeLeagueName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $homeLeagueRegion = null;

    #[ORM\OneToMany(mappedBy: 'dataTeam', targetEntity: Team::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

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

    public function getAlternativeImage(): ?string
    {
        return $this->alternativeImage;
    }

    public function setAlternativeImage(?string $alternativeImage): static
    {
        $this->alternativeImage = $alternativeImage;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getHomeLeagueName(): ?string
    {
        return $this->homeLeagueName;
    }

    public function setHomeLeagueName(?string $homeLeagueName): static
    {
        $this->homeLeagueName = $homeLeagueName;

        return $this;
    }

    public function getHomeLeagueRegion(): ?string
    {
        return $this->homeLeagueRegion;
    }

    public function setHomeLeagueRegion(?string $homeLeagueRegion): static
    {
        $this->homeLeagueRegion = $homeLeagueRegion;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setDataTeam($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getDataTeam() === $this) {
                $team->setDataTeam(null);
            }
        }

        return $this;
    }
}
