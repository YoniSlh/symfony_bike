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
                'image_urls' => [
                    'https://cdn.shoplightspeed.com/shops/639663/files/52631120/image.jpg',
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Portrait',
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Alt1',
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Alt8'
                ]
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
                'image_urls' => [
                    'https://www.velobrival.com/app/uploads/2024/04/lorpa.jpg'
                ]
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
                'image_urls' => [
                    'https://www.cubebikes.fr/26230-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/26234-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/30102-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/26232-pdt_1920/stereo-hybrid-one44-hpc.jpg'
                ]
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
                'image_urls' => [
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg'
                ]
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
                ->setMarque($data['marque'])
                ->setImageUrls($data['image_urls']);

            $type = $this->getReference($data['type_ref']);
            $product->setType($type);

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
