<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductStatus;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
            ['name' => 'TREK Madone SLR 6 eTap 7e génération Rouge Métallique', 'price' => 500.00, 'description' => 'Un vélo de route léger', 'stock' => 10, 'status' => ProductStatus::DISPONIBLE, 'type_id' => 1],
            ['name' => 'VTT LAPIERRE Edge 3.7 Gris', 'price' => 1000.00, 'description' => 'Conçu pour les terrains accidentés', 'stock' => 0, 'status' => ProductStatus::RUPTURE_DE_STOCK, 'type_id' => 2],
            ['name' => 'Riverside 100 E Vert', 'price' => 1500.00, 'description' => 'Vélo avec assistance électrique', 'stock' => 8, 'status' => ProductStatus::PRECOMMANDE, 'type_id' => 3],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name'])
                ->setPrice($data['price'])
                ->setDescription($data['description'])
                ->setStock($data['stock'])
                ->setStatus($data['status']);

            $type = $manager->getRepository(Type::class)->findOneBy(['id' => $data['type_id']]);
            if (!$type) {
                throw new \Exception('Type with id ' . $data['type_id'] . ' not found');
            }
            $product->setType($type);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
