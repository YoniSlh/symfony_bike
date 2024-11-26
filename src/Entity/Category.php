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

    #[ORM\Column(name: "category_nom", length: 255)]
    private ?string $CategoryName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->CategoryName;
    }

    public function setCategoryName(?string $CategoryName): self
    {
        $this->CategoryName = $CategoryName;
        return $this;
    }

    public function __toString(): string
    {
        return $this->CategoryName ?? '';
    }
}
