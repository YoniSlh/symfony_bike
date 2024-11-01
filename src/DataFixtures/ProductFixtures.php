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
            [
                'name' => 'Madone SLR 6 7e gén.',
                'type_ref' => 'type_1',
                'price' => 7599.00,
                'description' => 'Vélo de route léger et performant, idéal pour les compétitions',
                'stock' => 10,
                'status' => ProductStatus::DISPONIBLE,
                'poids' => 7.5,
                'couleur' => 'Rouge',
                'marque' => 'Trek',
                'image_refs' => ['image_1']
            ],
            [
                'name' => 'Overvolt AM 9.7 2024',
                'type_ref' => 'type_3',
                'price' => 5789.00,
                'description' => 'VTT électrique puissant, parfait pour les aventures tout-terrain',
                'stock' => 17,
                'status' => ProductStatus::DISPONIBLE,
                'poids' => 11.2,
                'couleur' => 'Noir',
                'marque' => 'Lapierre',
                'image_refs' => ['image_2']
            ],
            [
                'name' => 'Stereo Hybrid ONE44 HPC',
                'type_ref' => 'type_3',
                'price' => 5450.00,
                'description' => 'Vélo avec assistance électrique, idéal pour les longues randonnées',
                'stock' => 8,
                'status' => ProductStatus::DISPONIBLE,
                'poids' => 24.4,
                'couleur' => 'Bleu',
                'marque' => 'Cube',
                'image_refs' => ['image_3']
            ],
            [
                'name' => 'Edge 3.7',
                'type_ref' => 'type_2',
                'price' => 649.00,
                'description' => 'Conçu pour les terrains accidentés, ce VTT offre une excellente maniabilité',
                'stock' => 0,
                'status' => ProductStatus::RUPTURE_DE_STOCK,
                'poids' => 12.0,
                'couleur' => 'Gris',
                'marque' => 'Lapierre',
                'image_refs' => ['image_4']
            ]
        ];

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

            foreach ($data['image_refs'] as $image_ref) {
                $image = $this->getReference($image_ref);
                $product->addImage($image);
            }

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
