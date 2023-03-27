<?php

namespace App\DataFixtures;

use App\Entity\ProductModel;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            switch ($i) {
                case 0:
                    $name = 'iPhone 12 Pro';
                    $brand = 0;
                    $screen_size = '6.1"';
                    $technical_details = '6.1 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14';
                    break;
                case 1:
                    $name = 'iPhone 13 Pro Max';
                    $brand = 0;
                    $screen_size = '6.7"';
                    $technical_details = '6.7 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14';
                    break;
                case 2:
                    $name = 'iPhone XS';
                    $screen_size = '5.8"';
                    $technical_details = '5.8 pouces, 128 Go, 4G, 12 Mpx, iOS 14';
                    break;
                case 3:
                    $name = 'iPhone 11 Pro';
                    $brand = 0;
                    $screen_size = '5.8"';
                    $technical_details = '5.8 pouces, 128 Go, 4G, 5G, 12 Mpx, iOS 14';
                    break;
                case 4:
                    $name = 'Samsung Galaxy S21';
                    $brand = 1;
                    $screen_size = '6.2"';
                    $technical_details = '6.2 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11';
                    break;
                case 5:
                    $name = 'Sammsung Galaxy Note 20';
                    $brand = 1;
                    $screen_size = '6.7"';
                    $technical_details = '6.7 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11';
                    break;
                case 6:
                    $name = 'Samsung Galaxy S20';
                    $brand = 1;
                    $screen_size = '6.2"';
                    $technical_details = '6.2 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 11';
                    break;
                case 7:
                    $name = 'Huawei P40 Pro';
                    $brand = 2;
                    $screen_size = '6.58"';
                    $technical_details = '6.58 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 10';
                    break;
                case 8:
                    $name = 'Huawei P30 Pro';
                    $brand = 2;
                    $screen_size = '6.47"';
                    $technical_details = '6.47 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 10';
                    break;
                case 9:
                    $name = 'Huawei P20 Pro';
                    $brand = 2;
                    $screen_size = '6.1"';
                    $technical_details = '6.1 pouces, 128 Go, 4G, 5G, 12 Mpx, Android 10';
                    break;
                default:
                    throw new \Exception('Invalid data in ProductModelFixtures');
            }

            $this->createProduct($i, $name, $brand, $screen_size, $technical_details, $manager);
        }

        $manager->flush();
    }
    public function createProduct(int $productId, string $name, int $brand, string $screen_size, string $technical_details = null, ObjectManager $manager)
    {
        $productModel = new ProductModel();
        $productModel->setBrand($this->getReference('product-brand-' . $brand));
        $productModel->setName($name);
        $productModel->setScreenSize($screen_size);
        $productModel->setTechnicalDetails($technical_details);
        $this->addReference('product-model-' . $productId, $productModel);

        $manager->persist($productModel);

        return $productModel;
    }

    public function getDependencies(): array
    {
        return [
            ProductBrandFixtures::class
        ];
    }
}
