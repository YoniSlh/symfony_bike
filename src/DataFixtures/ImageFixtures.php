<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $images = ['https://cdn.shoplightspeed.com/shops/639663/files/52631120/image.jpg', 'https://www.velobrival.com/app/uploads/2024/04/lorpa.jpg', 'https://www.cubebikes.fr/26230-pdt_1920/stereo-hybrid-one44-hpc.jpg', 'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg'];

        foreach ($images as $index => $imagesURL) {
            $images = new Image();
            $images->setUrl($imagesURL);
            $manager->persist($images);

            $this->addReference('image_' . ($index + 1), $images);
        }

        $manager->flush();
    }
}
