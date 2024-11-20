<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getCartItemForProduct(Product $product): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                return $item;
            }
        }

        return null;
    }

    public function getTotal(): float
    {
        return array_reduce(
            $this->items->toArray(),
            fn ($sum, CartItem $item) => $sum + $item->getQuantity() * $item->getProduct()->getPrice(),
            0
        );
    }

    public function getItemCount(): int
    {
        return array_reduce(
            $this->items->toArray(),
            fn ($count, CartItem $item) => $count + $item->getQuantity(),
            0
        );
    }
}
