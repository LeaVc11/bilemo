<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $customer = (new Customer())
                ->setName($faker->name())
                ->setEmail($faker->email())
                ->setUser($faker->user());

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
