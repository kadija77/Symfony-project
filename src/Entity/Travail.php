<?php

namespace App\Entity;

use App\Repository\TravailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TravailRepository::class)
 */
class Travail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="travail")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="travail")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DepotTravail", mappedBy="travail")
     */
    private $depotTravail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }
    public function setCategorie(Categorie $categorie)
    {
        $this->category = $categorie;
    }
    public function getCategorie() 
    {
        return $this->category;
    }
    public function setUser(User $user) {
        $this->user = $user;
    }
    public function getUser() {
        return $this->user;
    }
    public function getDepotTravail() {
        return $this->depotTravail;
    }
}
