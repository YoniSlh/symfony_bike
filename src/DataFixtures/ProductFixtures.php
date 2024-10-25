<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductStatus;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $products = [
            ['name' => 'TREK Madone SLR 6 eTap 7e', 'image_id' => 1, 'type_ref' => 'type_1', 'price' => 500.00, 'description' => 'Un vélo de route léger', 'stock' => 10, 'status' => ProductStatus::DISPONIBLE],
            ['name' => 'VTT LAPIERRE Edge 3.7', 'image_id' => 2, 'type_ref' => 'type_2', 'price' => 1000.00, 'description' => 'Conçu pour les terrains accidentés', 'stock' => 0, 'status' => ProductStatus::RUPTURE_DE_STOCK],
            ['name' => 'Riverside 100 E', 'image_id' => 3, 'type_ref' => 'type_3', 'price' => 1500.00, 'description' => 'Vélo avec assistance électrique', 'stock' => 8, 'status' => ProductStatus::PRECOMMANDE],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name'])
                ->setPrice($data['price'])
                ->setDescription($data['description'])
                ->setStock($data['stock'])
                ->setStatus($data['status']);

            $type = $this->getReference($data['type_ref']);
            $product->setType($type);

            $image = $this->getReference('image_' . $data['image_id']);
            $product->setImage($image);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TypeFixtures::class,
            ImageFixtures::class,
        ];
    }
}
