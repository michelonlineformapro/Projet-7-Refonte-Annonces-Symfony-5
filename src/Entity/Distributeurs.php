<?php

namespace App\Entity;

use App\Repository\DistributeursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DistributeursRepository::class)
 */
class Distributeurs
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
    private $nomDistributeur;

    /**
     * @ORM\ManyToMany(targetEntity=Annonces::class, mappedBy="distributeurs")
     */
    private $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDistributeur(): ?string
    {
        return $this->nomDistributeur;
    }

    public function setNomDistributeur(string $nomDistributeur): self
    {
        $this->nomDistributeur = $nomDistributeur;

        return $this;
    }

    /**
     * @return Collection|Annonces[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonces $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->addDistributeur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            $annonce->removeDistributeur($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomDistributeur;
    }
}
