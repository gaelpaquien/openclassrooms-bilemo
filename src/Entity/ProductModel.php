<?php

namespace App\Entity;

use App\Repository\ProductModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductModelRepository::class)]
class ProductModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'productModels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductBrand $brand = null;

    #[ORM\Column(length: 10)]
    private ?string $screen_size = null;

    #[ORM\Column(length: 255)]
    private ?string $technical_details = null;

    #[ORM\OneToMany(mappedBy: 'model', targetEntity: ProductStock::class, orphanRemoval: true)]
    private Collection $productStocks;

    public function __construct()
    {
        $this->productStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }

    public function setBrand(?ProductBrand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screen_size;
    }

    public function setScreenSize(string $screen_size): self
    {
        $this->screen_size = $screen_size;

        return $this;
    }

    public function getTechnicalDetails(): ?string
    {
        return $this->technical_details;
    }

    public function setTechnicalDetails(?string $technical_details): self
    {
        $this->technical_details = $technical_details;

        return $this;
    }

    /**
     * @return Collection<int, ProductStock>
     */
    public function getProductStocks(): Collection
    {
        return $this->productStocks;
    }

    public function addProductStock(ProductStock $productStock): self
    {
        if (!$this->productStocks->contains($productStock)) {
            $this->productStocks->add($productStock);
            $productStock->setModel($this);
        }

        return $this;
    }

    public function removeProductStock(ProductStock $productStock): self
    {
        if ($this->productStocks->removeElement($productStock)) {
            // set the owning side to null (unless already changed)
            if ($productStock->getModel() === $this) {
                $productStock->setModel(null);
            }
        }

        return $this;
    }
}
