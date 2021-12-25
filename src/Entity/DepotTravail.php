<?php

namespace App\Entity;

use App\Repository\DepotTravailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepotTravailRepository::class)
 */
class DepotTravail
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $note;
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depotTravail")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Travail", inversedBy="depotTravail")
    */    
    private $travail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function setNote(float $note) {
        $this->note = $note;
    }
    public function getNote() {
        return $this->note;
    }
    public function setUser(User $user) {
        $this->user = $user;
    }
    public function getUser() {
        return $this->user;
    }
    public function setTravail(Travail $travail) {
        $this->travail = $travail;
    }
    public function getTravail() {
        return $this->travail;
    }
}
