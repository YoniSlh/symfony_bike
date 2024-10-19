<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $images = ['https://cdn.shoplightspeed.com/shops/639663/files/52631120/image.jpg', 'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg', 'https://contents.mediadecathlon.com/p2322274/k$4d098d3fb93da124b4f9fff26c009f72/sq/velo-tout-chemin-electrique-cadre-bas-riverside-100-e-vert.jpg?format=auto&f=1800x1800'];

        foreach ($images as $index => $imagesURL) {
            $images = new Image();
            $images->setUrl($imagesURL);
            $manager->persist($images);

            $this->addReference('image_' . ($index + 1), $images);
        }

        $manager->flush();
    }
}
