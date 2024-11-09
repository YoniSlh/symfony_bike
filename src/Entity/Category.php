<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categoryNom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryNom(): ?string
    {
        return $this->categoryNom;
    }

    public function setCategoryNom(?string $categoryNom): self
    {
        $this->categoryNom = $categoryNom;
        return $this;
    }

    public function __toString(): string
    {
        return $this->categoryNom ?? '';
    }
}
