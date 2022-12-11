<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomersFixtures extends Fixture implements DependentFixtureInterface
{
    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        foreach($this->UserRepository->findAll() as $user) {
            for ($i = 0; $i < 20; $i++) {
                $customer = (new Customer())
                    ->setName($faker->name())
                    ->setEmail($faker->email())
                    ->setUser($user);
                $manager->persist($customer);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
        ];
    }
}
