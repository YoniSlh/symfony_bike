<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = ['Vélo de route', 'Vélo tout terrain', 'Vélo électrique'];

        foreach ($types as $index => $typeNom) {
            $typeExistant = $manager->getRepository(Type::class)->findOneBy(['typeNom' => $typeNom]);

            if (!$typeExistant) {
                $type = new Type();
                $type->setTypeNom($typeNom);
                $manager->persist($type);

                $this->addReference('type_' . ($index + 1), $type);
            }
        }

        $manager->flush();
    }
}
