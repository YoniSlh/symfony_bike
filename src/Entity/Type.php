<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeNom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeNom(): ?string
    {
        return $this->typeNom;
    }

    public function setTypeNom(?string $typeNom): self
    {
        $this->typeNom = $typeNom;
        return $this;
    }
}
