<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'json')]
    private array $urls = [];

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    public function setUrls(array $urls): self
    {
        if (count($urls) > 4) {
            throw new \InvalidArgumentException('Vous ne pouvez pas ajouter plus de 4 URLs.');
        }
        $this->urls = $urls;
        return $this;
    }

    public function addUrl(string $url): self
    {
        if (count($this->urls) >= 4) {
            throw new \InvalidArgumentException('Vous ne pouvez pas ajouter plus de 4 URLs.');
        }
        $this->urls[] = $url;
        return $this;
    }

    public function removeUrl(string $url): self
    {
        if (($key = array_search($url, $this->urls)) !== false) {
            unset($this->urls[$key]);
        }
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function __toString(): string
    {
        return implode(', ', $this->urls);
    }
}
