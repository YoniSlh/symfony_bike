<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Vélo de route', 'Vélo tout terrain', 'Vélo électrique'];

        foreach ($types as $typeNom) {
            $type = new Type();
            $type->setTypeNom($typeNom);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
