<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_user = null;

    #[ORM\Column(length: 255)]
    private ?string $texte_avis = null;

    #[ORM\Column]
    private ?int $etoiles = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_avis = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUser(): ?string
    {
        return $this->nom_user;
    }

    public function setNomUser(string $nom_user): static
    {
        $this->nom_user = $nom_user;
        return $this;
    }

    public function getTexteAvis(): ?string
    {
        return $this->texte_avis;
    }

    public function setTexteAvis(string $texte_avis): static
    {
        $this->texte_avis = $texte_avis;
        return $this;
    }

    public function getEtoiles(): ?int
    {
        return $this->etoiles;
    }

    public function setEtoiles(int $etoiles): static
    {
        $this->etoiles = $etoiles;
        return $this;
    }

    public function getDateAvis(): ?\DateTimeInterface
    {
        return $this->date_avis;
    }

    public function setDateAvis(\DateTimeInterface $date_avis): static
    {
        $this->date_avis = $date_avis;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;
        return $this;
    }
}
