<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $productColor = new ProductColor();

            switch ($i) {
                case 0:
                    $productColor->setName('Gris sideral');
                    break;
                case 1:
                    $productColor->setName('Blanc');
                    break;
                case 2:
                    $productColor->setName('Noir');
                    break;
                case 3:
                    $productColor->setName('Or');
                    break;
                case 4:
                    $productColor->setName('Argent');
                    break;
                default:
                    throw new \Exception('Invalid data in ProductColorFixtures');
            }

            $this->addReference('product-color-' . $i, $productColor);

            $manager->persist($productColor);
        }

        $manager->flush();
    }
}
