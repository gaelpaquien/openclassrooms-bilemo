<?php

namespace App\DataFixtures;

use App\Entity\ProductBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductBrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $productBrand = new ProductBrand();

            switch ($i) {
                case 0:
                    $productBrand->setName('Apple');
                    break;
                case 1:
                    $productBrand->setName('Samsung');
                    break;
                case 2:
                    $productBrand->setName('Huawei');
                    break;
                default:
                    throw new \Exception('Invalid data in ProductBrandFixtures');
            }

            $this->addReference('product-brand-' . $i, $productBrand);
            $manager->persist($productBrand);
        }

        $manager->flush();
    }
}
