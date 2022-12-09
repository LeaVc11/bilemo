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
    private Faker\Generator $faker;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;

    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 25; $i++) {
            $user1 = new User();
            $user1->setEmail($faker->email());
            $user1->setCompanyName($faker->company());
            $user1->setRoles(["ROLE_ADMIN"]);
            $user1->setPassword($this->hasher->hashPassword($user1, "admin"));

            $manager->persist($user1);
        }
        for ($i = 0; $i < 25; $i++) {
            $user2 = new User();
            $user2->setEmail($faker->email());
            $user2->setCompanyName($faker->company());
            $user2->setRoles(["ROLE_USER"]);
            $user2->setPassword($this->hasher->hashPassword($user2, "user"));

            $manager->persist($user2);
        }
        $manager->flush();
    }
}
