<?php

namespace App\Entity;

use App\Repository\ProductStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductStockRepository::class)]
class ProductStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductModel $model = null;

    #[ORM\ManyToOne(inversedBy: 'productStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductColor $color = null;

    #[ORM\Column]
    private ?int $count = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?ProductModel
    {
        return $this->model;
    }

    public function setModel(?ProductModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?ProductColor
    {
        return $this->color;
    }

    public function setColor(?ProductColor $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
