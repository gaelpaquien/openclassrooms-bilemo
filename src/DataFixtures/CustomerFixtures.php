<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $this->createCustomer($i, 'company-0', $manager);
        }

        $manager->flush();
    }

    public function createCustomer(int $customerId, string $companyReference, ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $customer = new Customer();
        $customer->setCompany($this->getReference($companyReference));
        $customer->setUsername($faker->userName());
        $customer->setEmail($customer->getUsername() . '@email.fr');
        $customer->setPassword($faker->password());
        $customer->setPhoneNumber(0 . rand(6, 7) . rand(10000000, 99999999));

        $this->addReference('customer-' . $customerId, $customer);

        $manager->persist($customer);
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
