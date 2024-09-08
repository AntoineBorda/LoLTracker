<?php

namespace App\Entity\Account\User;

use App\Entity\App\Tracker\Player;
use App\Entity\App\Tracker\Tracker;
use App\Repository\Account\User\UserRepository;
use App\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.', )]
#[UniqueEntity(fields: ['pseudo'], message: 'Ce pseudo est déjà utilisé.', )]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\EntityListeners(['App\EventListener\UserListener'])]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;

    public function __toString(): string
    {
        return $this->pseudo;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner un email.', )]
    #[Assert\Email(message: 'Merci de renseigner un email valide.', )]
    #[Assert\Length(min: 6, max: 180, minMessage: 'L\'email doit contenir au moins {{ limit }} caractères.', maxMessage: 'L\'email doit contenir au maximum {{ limit }} caractères.', )]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[Assert\NotBlank(message: 'Merci de renseigner un mot de passe.', groups: ['registration'], )]
    #[Assert\Length(min: 8, max: 255, minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.', maxMessage: 'Le mot de passe doit contenir au maximum {{ limit }} caractères.', groups: ['registration'], )]
    private ?string $plainPassword = null;

    #[ORM\Column(type: Types::STRING, )]
    private ?string $password = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Merci de renseigner un pseudo.', )]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Votre pseudo doit contenir au moins {{ limit }} caractères.', maxMessage: 'Votre pseudo doit contenir au maximum {{ limit }} caractères.', )]
    private ?string $pseudo = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RiotInfo::class, cascade: ['remove'])]
    private Collection $riotInfos;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TwitchInfo::class, cascade: ['remove'])]
    private Collection $twitchInfos;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Tracker::class, cascade: ['remove'])]
    private Collection $trackers;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Player::class)]
    private Collection $players;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTimeImmutable();
        $this->riotInfos = new ArrayCollection();
        $this->twitchInfos = new ArrayCollection();
        $this->trackers = new ArrayCollection();
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, RiotInfo>
     */
    public function getRiotInfos(): Collection
    {
        return $this->riotInfos;
    }

    public function addRiotInfo(RiotInfo $riotInfo): static
    {
        if (!$this->riotInfos->contains($riotInfo)) {
            $this->riotInfos->add($riotInfo);
            $riotInfo->setUser($this);
        }

        return $this;
    }

    public function removeRiotInfo(RiotInfo $riotInfo): static
    {
        if ($this->riotInfos->removeElement($riotInfo)) {
            // set the owning side to null (unless already changed)
            if ($riotInfo->getUser() === $this) {
                $riotInfo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TwitchInfo>
     */
    public function getTwitchInfos(): Collection
    {
        return $this->twitchInfos;
    }

    public function addTwitchInfo(TwitchInfo $twitchInfo): static
    {
        if (!$this->twitchInfos->contains($twitchInfo)) {
            $this->twitchInfos->add($twitchInfo);
            $twitchInfo->setUser($this);
        }

        return $this;
    }

    public function removeTwitchInfo(TwitchInfo $twitchInfo): static
    {
        if ($this->twitchInfos->removeElement($twitchInfo)) {
            // set the owning side to null (unless already changed)
            if ($twitchInfo->getUser() === $this) {
                $twitchInfo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tracker>
     */
    public function getTrackers(): Collection
    {
        return $this->trackers;
    }

    public function addTracker(Tracker $tracker): static
    {
        if (!$this->trackers->contains($tracker)) {
            $this->trackers->add($tracker);
            $tracker->setUser($this);
        }

        return $this;
    }

    public function removeTracker(Tracker $tracker): static
    {
        if ($this->trackers->removeElement($tracker)) {
            // set the owning side to null (unless already changed)
            if ($tracker->getUser() === $this) {
                $tracker->setUser(null);
            }
        }

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
            $player->setOwner($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getOwner() === $this) {
                $player->setOwner(null);
            }
        }

        return $this;
    }
}
