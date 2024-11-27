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
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Portrait',
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Alt1',
                    'https://media.trekbikes.com/image/upload/f_auto,fl_progressive:semi,q_auto,w_1920,h_1440,c_pad/MadoneSLR6_23_37416_D_Alt8'
                ],
            ],
            [
                'urls' => [
                    'https://embed.widencdn.net/img/dorelrl/syzqbicaov/1100px@1x/C23_C65403U_Moterra_Neo_Al_4_SBK_PD.webp?color=F1F1F1&q=99',
                    'https://embed.widencdn.net/img/dorelrl/ts2c4df4jr/1100px@1x/C23_C65403U_Moterra_Neo_Al_4_SBK_3Q.webp?color=F1F1F1&q=99',
                    'https://embed.widencdn.net/img/dorelrl/iaecmau9et/1100px@1x/C23_C65403U_Moterra_Neo_Al_4_SBK_D2.webp?color=F1F1F1&q=99',
                    'https://embed.widencdn.net/img/dorelrl/lbpthgs0tv/1100px@1x/C23_C65403U_Moterra_Neo_Al_4_SBK_D3.webp?color=F1F1F1&q=99'
                ],
            ],
            [
                'urls' => [
                    'https://www.cubebikes.fr/26230-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/26234-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/30102-pdt_1920/stereo-hybrid-one44-hpc.jpg',
                    'https://www.cubebikes.fr/26232-pdt_1920/stereo-hybrid-one44-hpc.jpg'
                ],
            ],
            [
                'urls' => [
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg',
                    'https://www.velobrival.com/app/uploads/2020/12/Edge-7.9-F130-artwork.jpg'
                ],
            ]
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
