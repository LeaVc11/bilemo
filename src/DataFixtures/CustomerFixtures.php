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
        /** @var User $user1 */
        $user1 = $this->getReference(UsersFixtures::USER_REFERENCE);
        /** @var User $user2 */
        $user2 = $this->getReference(UsersFixtures::USER_REFERENCE . 'user2');

        $customerRepository = $manager->getRepository(Customer::class);
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 20; $i++) {
            $customer1 = (new Customer())
                ->setName($faker->name())
                ->setEmail($faker->email())
                ->setOwner($user1);

            $customerRepository->add($customer1);

            $customer2 = (new Customer())
                ->setName($faker->name())
                ->setEmail($faker->email())
                ->setOwner($user2);
            $customerRepository->add($customer2);
        }
        $manager->persist($user1);
        $manager->persist($user2);
        $listUser[] = $user1;
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
        ];
    }
}
