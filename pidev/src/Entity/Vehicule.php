<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\Column(type:"string" ,length: 10)]
 #[Assert\Regex(
        pattern : "/^\d{3}-\d{4}$/",
        message : "l'immatriculation doit etre sous ce format  XXX-XXXX, ou X est un chiffre"
    )]
    #[Assert\NotBlank]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your brand must be at least {{ limit }} characters long',
        maxMessage: 'Your brand cannot be longer than {{ limit }} characters',
    )]
    #[Assert\NotBlank]
    private ?string $marque = null;


    #[ORM\Column(length: 255)]
    #[Assert\Range(
        min : 3,
        max : 7,
        notInRangeMessage : 'la puissance doit etre entre {{ min }} et {{ max }} ',
)]
    #[Assert\NotBlank]

    private ?string $puissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $kilometrage = null;

    #[ORM\Column]
    #[Assert\Range(
        min : 1,
        max : 5,
        notInRangeMessage : 'le nombre de personnes doit etre entre {{ min }}  {{ max }} ',
)]
    #[Assert\NotBlank]

    private ?int $nbrdeplace = null;

    #[ORM\Column]
    #[Assert\NotBlank]

    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Typevehicule $typeVehicule = null;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setVehicule($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVehicule() === $this) {
                $reservation->setVehicule(null);
            }
        }

        return $this;
    }
}
