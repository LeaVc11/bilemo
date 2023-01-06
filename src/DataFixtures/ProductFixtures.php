<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = (new Product())
                ->setName("Nom : $i")
                ->setDescription("Description :  $i")
                ->setBrand("Marque :  $i")
                ->setPrice($i * 100)
                ->setCreatedAt(new DateTimeImmutable('-1 day'))
                ->setUpdatedAt(new DateTimeImmutable());
            $manager->persist($product);
        }
        $manager->flush();
    }
}
