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
            ['name' => 'Madone SLR 6 7e gén.', 'image_id' => 1, 'type_ref' => 'type_1', 'price' => 7599.00, 'description' => 'Vélo de route léger et performant, idéal pour les compétitions', 'stock' => 10, 'status' => ProductStatus::DISPONIBLE, 'poids' => 7.5, 'couleur' => 'Rouge', 'marque' => 'Trek'],
            ['name' => 'Overvolt AM 9.7 2024', 'image_id' => 2, 'type_ref' => 'type_3', 'price' => 5789.00, 'description' => 'VTT électrique puissant, parfait pour les aventures tout-terrain', 'stock' => 17, 'status' => ProductStatus::DISPONIBLE, 'poids' => 11.2, 'couleur' => 'Noir', 'marque' => 'Lapierre'],
            ['name' => 'Stereo Hybrid ONE44 HPC', 'image_id' => 3, 'type_ref' => 'type_3', 'price' => 5450.00, 'description' => 'Vélo avec assistance électrique, idéal pour les longues randonnées', 'stock' => 8, 'status' => ProductStatus::PRECOMMANDE, 'poids' => 24.4, 'couleur' => 'Bleu', 'marque' => 'Cube'],
            ['name' => 'Edge 3.7', 'image_id' => 4, 'type_ref' => 'type_2', 'price' => 649.00, 'description' => 'Conçu pour les terrains accidentés, ce VTT offre une excellente maniabilité', 'stock' => 0, 'status' => ProductStatus::RUPTURE_DE_STOCK, 'poids' => 12.0, 'couleur' => 'Gris', 'marque' => 'Lapierre']];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name'])
                ->setPrice($data['price'])
                ->setDescription($data['description'])
                ->setStock($data['stock'])
                ->setStatus($data['status'])
                ->setPoids($data['poids'])
                ->setCouleur($data['couleur'])
                ->setMarque($data['marque']);

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
