<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 20; $i++) {
            $customer = (new Customer())
                ->setName($faker->name())
                ->setEmail($faker->email());
        }
        $this->addReference(UsersFixtures::USER_REFERENCE . $i, $customer);

        $manager->persist($customer);
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
        ];
    }
}
