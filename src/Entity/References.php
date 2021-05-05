<?php

namespace App\Entity;

use App\Repository\ReferencesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferencesRepository::class)
 * @ORM\Table(name="`references`")
 */
class References
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @return int|null
     */
    private $numeroReference;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroReference(): ?int
    {
        return $this->numeroReference;
    }

    public function setNumeroReference(int $numeroReference): self
    {
        $this->numeroReference = $numeroReference;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->numeroReference;
    }

}
