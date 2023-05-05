<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $NomAg = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $NombreAg = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $RefAg = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $EmailAg = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $AdresseAg = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $VilleAg = null;

  

    #[ORM\OneToMany(mappedBy: 'agence', targetEntity: Typevehicule::class, orphanRemoval: true)]
    private Collection $typevehicules;

    #[ORM\ManyToOne(inversedBy: 'agences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->typevehicules = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAg(): ?string
    {
        return $this->NomAg;
    }

    public function setNomAg(string $NomAg): self
    {
        $this->NomAg = $NomAg;

        return $this;
    }

    public function getNombreAg(): ?string
    {
        return $this->NombreAg;
    }

    public function setNombreAg(string $NombreAg): self
    {
        $this->NombreAg = $NombreAg;

        return $this;
    }

    public function getRefAg(): ?string
    {
        return $this->RefAg;
    }

    public function setRefAg(string $RefAg): self
    {
        $this->RefAg = $RefAg;

        return $this;
    }

    public function getEmailAg(): ?string
    {
        return $this->EmailAg;
    }

    public function setEmailAg(string $EmailAg): self
    {
        $this->EmailAg = $EmailAg;

        return $this;
    }

    public function getAdresseAg(): ?string
    {
        return $this->AdresseAg;
    }

    public function setAdresseAg(string $AdresseAg): self
    {
        $this->AdresseAg = $AdresseAg;

        return $this;
    }

    public function getVilleAg(): ?string
    {
        return $this->VilleAg;
    }

    public function setVilleAg(string $VilleAg): self
    {
        $this->VilleAg = $VilleAg;

        return $this;
    }

   

   

    /**
     * @return Collection<int, Typevehicule>
     */
    public function getTypevehicules(): Collection
    {
        return $this->typevehicules;
    }

    public function addTypevehicule(Typevehicule $typevehicule): self
    {
        if (!$this->typevehicules->contains($typevehicule)) {
            $this->typevehicules->add($typevehicule);
            $typevehicule->setAgence($this);
        }

        return $this;
    }

    public function removeTypevehicule(Typevehicule $typevehicule): self
    {
        if ($this->typevehicules->removeElement($typevehicule)) {
            // set the owning side to null (unless already changed)
            if ($typevehicule->getAgence() === $this) {
                $typevehicule->setAgence(null);
            }
        }

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

    public function __toString(){
        return $this->getNomAg();
    }
    
}
