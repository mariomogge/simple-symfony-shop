<?php

namespace SimpleShop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column]
    private int $stock;

    #[ORM\ManyToOne(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private ?ProductCategory $category = null;

    #[ORM\OneToMany(targetEntity: TechnicalSpecification::class, mappedBy: 'product', cascade: ['persist'])]
    private Collection $specifications;

    #[ORM\ManyToMany(targetEntity: Material::class)]
    private Collection $materials;

    public function __construct()
    {
        $this->specifications = new ArrayCollection();
        $this->materials = new ArrayCollection();
    }

    // Getter und Setter Methoden
}
