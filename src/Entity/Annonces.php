<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=AnnoncesRepository::class)
 * @UniqueEntity(fields="nomAnnonces", message="Erreur : un produit possède déja ce nom dans notre base de données")
 * @Vich\Uploadable()
 */
class Annonces
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=6,
     *     max=50,
     *     minMessage="Le nom de l'annonce doit contenir au moin {{ limit }} caractères",
     *     maxMessage="Le nom de l'annonce ne doit pas depasser {{ limit }} caractères"
     * )
     */
    private $nomAnnonces;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=10,
     *     max=1000,
     *     minMessage="La description de l'annonce doit contenir au moin {{ limit }} caractères",
     *     maxMessage="La description de l'annonce ne doit pas depasser {{ limit }} caractères"
     * )
     */
    private $descriptionAnnonces;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $prixAnnonces;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(maxSize="6000000", maxSizeMessage="Le fichier est trop lourd ({{ size }} {{ suffix }}). La taille maximale autorisée est : {{ limit }} {{ suffix }}"),
     */
    private $imageAnnonces;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAnnonces;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stockAnnonce;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="annonces",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Regions::class, inversedBy="annonces",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $regions;

    /**
     * @ORM\OneToOne(targetEntity=References::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @return int|null
     */
    private $numero;

    /**
     * @ORM\ManyToMany(targetEntity=Distributeurs::class, inversedBy="annonces")
     */
    private $distributeurs;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="annonces")
     */
    private $commentaires;

    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
        $this->updateAt = new \DateTime();
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAnnonces(): ?string
    {
        return $this->nomAnnonces;
    }

    public function setNomAnnonces(string $nomAnnonces): self
    {
        $this->nomAnnonces = $nomAnnonces;

        return $this;
    }

    public function getDescriptionAnnonces(): ?string
    {
        return $this->descriptionAnnonces;
    }

    public function setDescriptionAnnonces(string $descriptionAnnonces): self
    {
        $this->descriptionAnnonces = $descriptionAnnonces;

        return $this;
    }

    public function getPrixAnnonces(): ?float
    {
        return $this->prixAnnonces;
    }

    public function setPrixAnnonces(float $prixAnnonces): self
    {
        $this->prixAnnonces = $prixAnnonces;

        return $this;
    }

    public function getImageAnnonces(): ?string
    {
        return $this->imageAnnonces;
    }

    public function setImageAnnonces(string $imageAnnonces): self
    {
        $this->imageAnnonces = $imageAnnonces;

        return $this;
    }

    public function getDateAnnonces(): ?\DateTimeInterface
    {
        return $this->dateAnnonces;
    }

    public function setDateAnnonces(\DateTimeInterface $dateAnnonces): self
    {
        $this->dateAnnonces = $dateAnnonces;

        return $this;
    }

    public function getStockAnnonce(): ?bool
    {
        return $this->stockAnnonce;
    }

    public function setStockAnnonce(bool $stockAnnonce): self
    {
        $this->stockAnnonce = $stockAnnonce;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getRegions(): ?Regions
    {
        return $this->regions;
    }

    public function setRegions(?Regions $regions): self
    {
        $this->regions = $regions;

        return $this;
    }

    public function getNumero(): ?References
    {
        return $this->numero;
    }

    public function setNumero(?References $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection|Distributeurs[]
     */
    public function getDistributeurs(): Collection
    {
        return $this->distributeurs;
    }

    public function addDistributeur(Distributeurs $distributeur): self
    {
        if (!$this->distributeurs->contains($distributeur)) {
            $this->distributeurs[] = $distributeur;
        }

        return $this;
    }

    public function removeDistributeur(Distributeurs $distributeur): self
    {
        $this->distributeurs->removeElement($distributeur);

        return $this;
    }

    public function __toString(): string{
        return $this->categories;
    }

    public function getUtilisateurs(): ?User
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?User $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAnnonces($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAnnonces() === $this) {
                $commentaire->setAnnonces(null);
            }
        }

        return $this;
    }



}
