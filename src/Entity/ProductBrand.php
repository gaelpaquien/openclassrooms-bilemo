<?php

namespace App\Entity;

use App\Repository\ProductBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductBrandRepository::class)]
class ProductBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: ProductModel::class, orphanRemoval: true)]
    private Collection $productModels;

    public function __construct()
    {
        $this->productModels = new ArrayCollection();
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

    /**
     * @return Collection<int, ProductModel>
     */
    public function getProductModels(): Collection
    {
        return $this->productModels;
    }

    public function addProductModel(ProductModel $productModel): self
    {
        if (!$this->productModels->contains($productModel)) {
            $this->productModels->add($productModel);
            $productModel->setBrand($this);
        }

        return $this;
    }

    public function removeProductModel(ProductModel $productModel): self
    {
        if ($this->productModels->removeElement($productModel)) {
            // set the owning side to null (unless already changed)
            if ($productModel->getBrand() === $this) {
                $productModel->setBrand(null);
            }
        }

        return $this;
    }
}
