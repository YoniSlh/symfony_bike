<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorys = ['Vélo de route', 'Vélo tout terrain', 'Vélo électrique'];

        foreach ($categorys as $index => $CategoryName) {
            $categoryExistant = $manager->getRepository(Category::class)->findOneBy(['CategoryName' => $CategoryName]);

            if (!$categoryExistant) {
                $category = new Category();
                $category->setCategoryName($CategoryName);
                $manager->persist($category);

                $this->addReference('category_' . ($index + 1), $category);
            }
        }

        $manager->flush();
    }
}
