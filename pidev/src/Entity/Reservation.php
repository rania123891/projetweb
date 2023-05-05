<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]

    private ?\DateTimeInterface $DateRes = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]

    private ?\DateTimeInterface $HeureRes = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $MethodP = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $DureeLoc = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $NomLoc = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $CinLoc = null;

    #[ORM\ManyToOne(targetEntity: Vehicule::class)]
    #[ORM\JoinColumn(name: 'vehicule_immatriculation', referencedColumnName: 'immatriculation')]
   
    private ?Vehicule $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->DateRes;
    }

    public function setDateRes(\DateTimeInterface $DateRes): self
    {
        $this->DateRes = $DateRes;

        return $this;
    }

    public function getHeureRes(): ?\DateTimeInterface
    {
        return $this->HeureRes;
    }

    public function setHeureRes(\DateTimeInterface $HeureRes): self
    {
        $this->HeureRes = $HeureRes;

        return $this;
    }

    public function getMethodP(): ?string
    {
        return $this->MethodP;
    }

    public function setMethodP(string $MethodP): self
    {
        $this->MethodP = $MethodP;

        return $this;
    }

    public function getDureeLoc(): ?string
    {
        return $this->DureeLoc;
    }

    public function setDureeLoc(string $DureeLoc): self
    {
        $this->DureeLoc = $DureeLoc;

        return $this;
    }

    public function getNomLoc(): ?string
    {
        return $this->NomLoc;
    }

    public function setNomLoc(string $NomLoc): self
    {
        $this->NomLoc = $NomLoc;

        return $this;
    }

    public function getCinLoc(): ?string
    {
        return $this->CinLoc;
    }

    public function setCinLoc(string $CinLoc): self
    {
        $this->CinLoc = $CinLoc;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
