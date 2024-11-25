<?php

namespace App\DataFixtures;

use App\Entity\CreditCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CreditCardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user1 = $this->getReference('user_1');
        $user2 = $this->getReference('user_2');
        $user3 = $this->getReference('user_3');

        $creditCards = [
            ['number' => '1234567812345678', 'user' => $user1, 'expirationDate' => new \DateTime('2025-12-31'), 'cvv' => 123],
            ['number' => '2345678923456789', 'user' => $user1, 'expirationDate' => new \DateTime('2026-06-30'), 'cvv' => 456],
            ['number' => '3456789034567890', 'user' => $user2, 'expirationDate' => new \DateTime('2024-05-31'), 'cvv' => 789],
            ['number' => '4567890145678901', 'user' => $user2, 'expirationDate' => new \DateTime('2025-11-30'), 'cvv' => 012],
            ['number' => '5678901256789012', 'user' => $user3, 'expirationDate' => new \DateTime('2024-03-31'), 'cvv' => 345],
            ['number' => '6789012367890123', 'user' => $user3, 'expirationDate' => new \DateTime('2027-09-30'), 'cvv' => 678],
        ];

        foreach ($creditCards as $cardData) {
            $card = new CreditCard();
            $card->setNumber($cardData['number']);
            $card->setExpirationDate($cardData['expirationDate']);
            $card->setCvv($cardData['cvv']);
            $card->setUser($cardData['user']);

            $manager->persist($card);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
