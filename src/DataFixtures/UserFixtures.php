<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUser('user@telecom-paris.com', 'password', ['ROLE_USER'], 'company-0', $manager);
        $this->createUser('admin@telecom-paris.com', 'password', ['ROLE_ADMIN'], 'company-0', $manager);

        $manager->flush();
    }

    public function createUser(string $email, string $password, array $roles, string $companyReference, ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setRoles($roles);
        $user->setCompany($this->getReference($companyReference));

        $manager->persist($user);
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
