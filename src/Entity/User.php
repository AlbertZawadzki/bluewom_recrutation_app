<?php

namespace App\Entity;

use App\Dictionary\RolesDictionary;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
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
     * @ORM\Column(type="text")
     */
    private string $roles = '[' . RolesDictionary::ROLE_USER . ']';

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nick;

    /**
     * @ORM\ManyToMany(targetEntity=Currency::class)
     */
    private $favouriteCurrencies;

    public function __construct()
    {
        $this->favouriteCurrencies = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->nick;
    }

    public function getUsername(): string
    {
        return (string)$this->id;
    }

    public function getRoles(): array
    {
        $roles = json_decode($this->roles, true);

        $roles[] = RolesDictionary::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * @return Collection|Currency[]
     */
    public function getFavouriteCurrencies(): Collection
    {
        return $this->favouriteCurrencies;
    }

    public function addFavouriteCurrency(Currency $favouriteCurrencies): self
    {
        if (!$this->favouriteCurrencies->contains($favouriteCurrencies)) {
            $this->favouriteCurrencies[] = $favouriteCurrencies;
        }

        return $this;
    }

    public function removeFavouriteCurrency(Currency $favouriteCurrencies): self
    {
        $this->favouriteCurrencies->removeElement($favouriteCurrencies);

        return $this;
    }
}
