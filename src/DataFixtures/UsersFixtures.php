<?php

namespace App\DataFixtures;

use App\Entity\User;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;

    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $userAdmin = new User();
            $userAdmin->setEmail($faker->email());
            $userAdmin->setCompanyName($faker->company());
            $userAdmin->setRoles(["ROLE_ADMIN"]);
            $userAdmin->setPassword($this->hasher->hashPassword($userAdmin, "admin"));

            $manager->persist($userAdmin);
        }
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setCompanyName($faker->company());
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($this->hasher->hashPassword($user, "user"));

            $manager->persist($user);
        }
        $manager->flush();
    }
}
