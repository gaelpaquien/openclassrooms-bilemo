<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setModel($this->getReference('product-model-' . $i));
            $product->setName($this->getReference('product-model-' . $i)->getName());
            $product->setDescription($faker->text(100));
            $product->setPrice(rand(350, 1100));
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductModelFixtures::class,
        ];
    }
}
