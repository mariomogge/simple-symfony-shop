<?php

namespace SimpleShop\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TechnicalSpecification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $key;

    #[ORM\Column(type: 'text')]
    private string $value;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'specifications')]
    private Product $product;
}
