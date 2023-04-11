<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $puissance = null;

    #[ORM\Column(length: 255)]
    private ?string $kilometrage = null;

    #[ORM\Column]
    private ?int $nbrdeplace = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Typevehicule $typeVehicule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(string $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getKilometrage(): ?string
    {
        return $this->kilometrage;
    }

    public function setKilometrage(string $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getNbrdeplace(): ?int
    {
        return $this->nbrdeplace;
    }

    public function setNbrdeplace(int $nbrdeplace): self
    {
        $this->nbrdeplace = $nbrdeplace;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTypeVehicule(): ?Typevehicule
    {
        return $this->typeVehicule;
    }

    public function setTypeVehicule(?Typevehicule $typeVehicule): self
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }
}
