<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\ProductStatus;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Image;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Madone SLR 6 7e gén.',
                'category_ref' => 'category_1',
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
                'name' => 'Moterra Carbon 4',
                'category_ref' => 'category_3',
                'price' => 4899.00,
                'description' => 'VTT électrique puissant, parfait pour les aventures tout-terrain',
                'stock' => 17,
                'status' => ProductStatus::DISPONIBLE,
                'poids' => 11.2,
                'couleur' => 'Gris',
                'marque' => 'Cannondale',
                'image_refs' => ['image_2']
            ],
            [
                'name' => 'Stereo Hybrid ONE44 HPC',
                'category_ref' => 'category_3',
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
                'category_ref' => 'category_2',
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

        foreach ($products as $index => $data) {
            $product = new Product();
            $product->setName($data['name'])
                ->setPrice($data['price'])
                ->setDescription($data['description'])
                ->setStock($data['stock'])
                ->setStatus($data['status'])
                ->setPoids($data['poids'])
                ->setCouleur($data['couleur'])
                ->setMarque($data['marque']);

            $category = $this->getReference($data['category_ref'], Category::class);
            $product->setCategory($category);

            foreach ($data['image_refs'] as $image_ref) {
                $image = $this->getReference($image_ref, Image::class);
                $product->addImage($image);
            }

            $manager->persist($product);

            $this->addReference('product_' . ($index + 1), $product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ImageFixtures::class,
        ];
    }
}
