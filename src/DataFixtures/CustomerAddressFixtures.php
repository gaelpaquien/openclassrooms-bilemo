<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\CustomerAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerAddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $customerId = $i;

            switch ($i) {
                case 0:
                    $address = '12 Rue de Paris';
                    $city = 'Paris';
                    $postalCode = '75000';
                    $addressDetails = 'Bâtiment A';
                    break;
                case 1:
                    $address = '4 Chemin de Lyon';
                    $city = 'Lyon';
                    $postalCode = '69000';
                    $addressDetails = 'Digicode : 1234';
                    break;
                case 2:
                    $address = '33 Avenue de Marseille';
                    $city = 'Marseille';
                    $postalCode = '13000';
                    $addressDetails = 'Appartement 3';
                    break;
                case 3:
                    $address = '9 Boulevard de Toulouse';
                    $city = 'Toulouse';
                    $postalCode = '31000';
                    $addressDetails = null;
                    break;
                case 4:
                    $address = '17 Place de Grenoble';
                    $city = 'Grenoble';
                    $postalCode = '38000';
                    $addressDetails = null;
                    break;
                default:
                    throw new \Exception('Invalid data address in CustomerAddressFixtures');
            }

            $this->createCustomerAddress($customerId, $address, $city, $postalCode, $addressDetails, $manager);
        }

        $manager->flush();
    }

    public function createCustomerAddress(int $customerId, string $address, string $city, string $postalCode, string $addressDetails = null, ObjectManager $manager): CustomerAddress
    {
        $customerAddress = new CustomerAddress();
        $customerAddress->setCustomer($this->getReference('customer-' . $customerId));
        $customerAddress->setCountry('France');
        $customerAddress->setAddress($address);
        $customerAddress->setCity($city);
        $customerAddress->setPostalCode($postalCode);
        $customerAddress->setAddressDetails($addressDetails);

        $manager->persist($customerAddress);

        return $customerAddress;
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
        ];
    }
}
