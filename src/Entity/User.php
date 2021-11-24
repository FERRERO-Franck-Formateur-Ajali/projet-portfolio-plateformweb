<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
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
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $is_banned;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $is_active;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $is_dead;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banned_reason;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $register_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $lastvisit_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $key_activation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $security;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\OneToOne(targetEntity=Compte::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    public function __construct()
    {
        $this->register_at = new \DateTimeImmutable();
        $this->lastvisit_at = new \DateTimeImmutable();
        $this->is_banned = false;
        $this->is_active = true;
        $this->is_dead = false;
        $this->roles = ['ROLE_USER'];
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
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

    public function getIsBanned(): ?bool
    {
        return $this->is_banned;
    }

    public function setIsBanned(bool $is_banned): self
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getIsDead(): ?bool
    {
        return $this->is_dead;
    }

    public function setIsDead(bool $is_dead): self
    {
        $this->is_dead = $is_dead;

        return $this;
    }

    public function getBannedReason(): ?string
    {
        return $this->banned_reason;
    }

    public function setBannedReason(?string $banned_reason): self
    {
        $this->banned_reason = $banned_reason;

        return $this;
    }

    public function getRegisterAt(): ?\DateTime
    {
        return $this->register_at;
    }

    public function setRegisterAt(\DateTime $register_at): self
    {
        $this->register_at = $register_at;

        return $this;
    }

    public function getLastvisitAt(): ?\DateTimeImmutable
    {
        return $this->lastvisit_at;
    }

    public function setLastvisitAt(\DateTimeImmutable $lastvisit_at): self
    {
        $this->lastvisit_at = $lastvisit_at;

        return $this;
    }

    public function getKeyActivation(): ?string
    {
        return $this->key_activation;
    }

    public function setKeyActivation(?string $key_activation): self
    {
        $this->key_activation = $key_activation;

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(string $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
