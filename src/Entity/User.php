<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="enum('etudiant','enseignant')")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Travail", mappedBy="user")
     */
    private $travail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DepotTravail", mappedBy="user")
     */
    private $depotTravail;

    public function  __construct()
    {
        $this->travail = new ArrayCollection();
        $this->depotTravail = new ArrayCollection();
    }
    public static function withData($username, $password, $type)
    {
        $instance = new self();
        $instance->username = $username;
        $instance->password = $password;
        $instance->setType($type);
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    public function setType(string $type)
    {
        if (!in_array($type, array("etudiant", "enseignant"))) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    /**
     * @return Collection|Travail[]
     */
    public function getTravail(): Collection
    {
        return $this->travail;
    }
    /**
     * @return Collection|DepotTravail[]
    */
    public function getDepotTravail() : Collection {
        return $this->depotTravail;
    }
    public function __toString()
    {
        return $this->username . " " . $this->password;
    }
}
