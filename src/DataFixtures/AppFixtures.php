<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const PRODUCTS_NB = 200;
    private const CATEGORIES_NB = 15;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0, $categories = []; $i < self::CATEGORIES_NB; $i++) {
            $category = new Category();
            $category
                ->setName($faker->colorName())
                ->setDescription($faker->realTextBetween(60, 180));
            $categories[] = $category;

            $manager->persist($category);
        }

        for ($i = 0; $i < self::PRODUCTS_NB; $i++) {
            $product = new Product();
            $product
                ->setName($faker->userName())
                ->setDescription($faker->realTextBetween(60, 180))
                ->setHTprice($faker->randomFloat(2, 1, 7999))
                ->setVisible($faker->boolean(90))
                ->setDiscount($faker->boolean(7))
                ->setDateCreated($faker->dateTimeBetween('-3 years'))
                ->setCategory(($categories[$faker->numberBetween(0, count($categories) - 1)]));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
