<?php

namespace App\Domain\Utilisateurs\Entity;

use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Core\Entity\Fichier;
use App\Domain\Core\Entity\Role;
use App\Domain\Utilisateurs\Repository\UtilisateurRepository;
use App\Infrastructure\Orm\Timestampable;
use App\Infrastructure\Orm\TimestampableEntity;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @method string getUserIdentifier()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateur implements UserInterface
{
    const ROLE_ADMINISTRATEUR = 'ROLE_ADMINISTRATEUR';
    const ROLE_MEMBRE = 'ROLE_MEMBRE';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBanned = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisible = false;

    /**
     * @ORM\ManyToOne(targetEntity=Fichier::class)
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class)
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now', new DateTimeZone('Europe/Paris')));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now', new DateTimeZone('Europe/Paris')));
        }
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $res =[];
        foreach ($this->roles as $role) {
            $res[] = $role->getSlug();
        }
        return $res;
    }

    /**
     * @return Collection|null
     */
    public function getRolesObject(): ?Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (is_null($this->getRolesObject()) || !$this->getRolesObject()->contains($role)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }


    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getAvatar(): ?Fichier
    {
        return $this->avatar;
    }

    public function setAvatar(?Fichier $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    #[Pure] public function hasRole(Role $role): bool
    {
        if(in_array($role, $this->roles, true)){
            return true;
        }
        return false;
    }

    /**
     * @param array $roles
     * @return bool
     */
    public function hasOneRole(array $roles) : bool
    {
        foreach ($roles as $role){
            if(in_array($role, $this->getRoles(), true)){
                return true;
            }
        }
        return false;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFullname() : string
    {
        return sprintf('%s %s', $this->getFirstName() ?? '' , $this->getLastName() ?? '');
    }

}
