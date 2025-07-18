<?php

namespace SimpleShop\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $colorCode = null;

}
