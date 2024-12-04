<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Product;

class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $avisData = [
            [
                'nom_user' => 'Jean Dupont',
                'texte_avis' => 'Un vélo exceptionnel ! Très confortable et rapide. Je le recommande vivement.',
                'etoiles' => 5,
                'date_avis' => '2024-03-12',
                'product_ref' => 'product_1',
            ],
            [
                'nom_user' => 'Sophie Lefèvre',
                'texte_avis' => 'Très satisfait. Léger, élégant et vraiment performant.',
                'etoiles' => 4,
                'date_avis' => '2024-03-10',
                'product_ref' => 'product_1',
            ],
            [
                'nom_user' => 'Paul Durand',
                'texte_avis' => 'Excellent vélo, bien que le prix soit un peu élevé.',
                'etoiles' => 4,
                'date_avis' => '2024-03-09',
                'product_ref' => 'product_1',
            ],

            [
                'nom_user' => 'Marie Curie',
                'texte_avis' => 'Un excellent rapport qualité-prix. Idéal pour les balades en ville.',
                'etoiles' => 4,
                'date_avis' => '2024-03-10',
                'product_ref' => 'product_2',
            ],
            [
                'nom_user' => 'Lucas Morel',
                'texte_avis' => 'Très robuste, parfait pour les chemins escarpés.',
                'etoiles' => 5,
                'date_avis' => '2024-03-08',
                'product_ref' => 'product_2',
            ],
            [
                'nom_user' => 'Claire Fontaine',
                'texte_avis' => 'Bonne maniabilité, mais un peu lourd.',
                'etoiles' => 3,
                'date_avis' => '2024-03-07',
                'product_ref' => 'product_2',
            ],

            [
                'nom_user' => 'Pierre Martin',
                'texte_avis' => 'J’adore ce vélo ! Sa maniabilité est incroyable. Parfait pour les sorties le week-end.',
                'etoiles' => 5,
                'date_avis' => '2024-03-08',
                'product_ref' => 'product_3',
            ],
            [
                'nom_user' => 'Emma Dubois',
                'texte_avis' => 'Vraiment génial pour les longues randonnées. Je suis ravie !',
                'etoiles' => 5,
                'date_avis' => '2024-03-06',
                'product_ref' => 'product_3',
            ],
            [
                'nom_user' => 'Hugo Bernard',
                'texte_avis' => 'Un peu cher, mais la qualité est indéniable.',
                'etoiles' => 4,
                'date_avis' => '2024-03-05',
                'product_ref' => 'product_3',
            ],

            [
                'nom_user' => 'Juliette Lefèvre',
                'texte_avis' => 'Parfait pour les terrains accidentés, je suis impressionnée.',
                'etoiles' => 5,
                'date_avis' => '2024-03-04',
                'product_ref' => 'product_4',
            ],
            [
                'nom_user' => 'Thomas Laurent',
                'texte_avis' => 'Très maniable, mais le confort pourrait être amélioré.',
                'etoiles' => 4,
                'date_avis' => '2024-03-03',
                'product_ref' => 'product_4',
            ],
            [
                'nom_user' => 'Alice Moreau',
                'texte_avis' => 'Bon produit, mais j’aurais aimé plus d’options de personnalisation.',
                'etoiles' => 3,
                'date_avis' => '2024-03-02',
                'product_ref' => 'product_4',
            ],
        ];

        foreach ($avisData as $data) {
            $avis = new Avis();
            $avis->setNomUser($data['nom_user'])
                ->setTexteAvis($data['texte_avis'])
                ->setEtoiles($data['etoiles'])
                ->setDateAvis(new \DateTime($data['date_avis']));

            $product = $this->getReference($data['product_ref'], Product::class);
            $avis->setProduct($product);

            $manager->persist($avis);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}
