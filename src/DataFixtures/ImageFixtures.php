<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $images = [
            [
                'urls' => [
                    'https://cdn.shoplightspeed.com/shops/639663/files/52631120/image.jpg',
                    'https://www.velobrival.com/app/uploads/2024/04/lorpa.jpg',
                ],
            ],
            [
                'urls' => [
                    'https://www.cubebikes.fr/26230-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                ],
            ],
        ];

        foreach ($images as $index => $imageData) {
            $image = new Image();
            $image->setUrls($imageData['urls']);
            $manager->persist($image);

            $this->addReference('image_' . ($index + 1), $image);
        }

        $manager->flush();
    }
}
