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
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $customer = new Customer();
            $customer->setCompany($this->getReference('company-orange'));
            $customer->setUsername($faker->userName());
            $customer->setEmail($customer->getUsername() . '@email.fr');
            $customer->setPassword($faker->password());
            if ($i % 2 === 0) {
                $customer->setPhoneNumber($faker->phoneNumber());
            }
            $this->addReference('customer-' . $i, $customer);

            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
