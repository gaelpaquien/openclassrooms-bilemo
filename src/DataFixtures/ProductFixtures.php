<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $this->createProduct(0, 0, 'iPhone 12 Pro', $faker->text(100), '6.1"', '6.1 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14', $manager);
        $this->createProduct(1, 0, 'iPhone 13 Pro Max', $faker->text(100), '6.7"', '6.7 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14', $manager);
        $this->createProduct(2, 0, 'iPhone XS', $faker->text(100), '5.8"', '5.8 pouces, 128 Go, 4G, 12 Mpx, iOS 14', $manager);
        $this->createProduct(3, 0, 'iPhone 11 Pro', $faker->text(100), '5.8"', '5.8 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14', $manager);
        $this->createProduct(4, 1, 'Samsung Galaxy S21', $faker->text(100), '6.2"', '6.2 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);
        $this->createProduct(5, 1, 'Sammsung Galaxy Note 20', $faker->text(100), '6.7"', '6.7 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);
        $this->createProduct(6, 1, 'Samsung Galaxy S20', $faker->text(100), '6.2"', '6.2 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);
        $this->createProduct(7, 2, 'Huawei P40 Pro', $faker->text(100), '6.58"', '6.58 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);
        $this->createProduct(8, 2, 'Huawei P30 Pro', $faker->text(100), '6.47"', '6.47 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);
        $this->createProduct(9, 2, 'Huawei P20 Pro', $faker->text(100), '6.1"', '6.1 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11', $manager);

        $manager->flush();
    }

    public function createProduct(
        int $productId,
        int $brand,
        string $name,
        string $description,
        string $screen_size,
        string $technical_details,
        ObjectManager $manager)
    {
        $product = new Product();
        $product->setBrand($this->getReference('product-brand-' . $brand));
        $product->setName($name);
        $product->setDescription($description);
        $product->setScreenSize($screen_size);
        $product->setTechnicalDetails($technical_details);
        $product->setPrice(rand(350, 1100));
        $this->addReference('product-' . $productId, $product);

        $manager->persist($product);
    }

}
