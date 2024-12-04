<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use App\Enum\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ordersData = [
            [
                'createdAt' => new \DateTimeImmutable('2024-01-01 10:00:00'),
                'status' => OrderStatus::EN_PREPARATION,
                'user_ref' => 'user_1',
                'reference' => 'ORDER-001',
                'price' => 649.00,
            ],
            [
                'createdAt' => new \DateTimeImmutable('2024-01-02 11:00:00'),
                'status' => OrderStatus::EXPEDIEE,
                'user_ref' => 'user_2',
                'reference' => 'ORDER-002',
                'price' => 7599.00,
            ],
            [
                'createdAt' => new \DateTimeImmutable('2024-01-03 12:00:00'),
                'status' => OrderStatus::LIVREE,
                'user_ref' => 'user_3',
                'reference' => 'ORDER-003',
                'price' => 5789.00,
            ],
        ];

        foreach ($ordersData as $orderData) {
            $order = new Order();
            $order->setCreatedAt($orderData['createdAt']);
            $order->setStatus($orderData['status']);
            $order->setPrice($orderData['price']);

            $user = $this->getReference($orderData['user_ref'], User::class);
            $order->setUser($user);
            $order->setReference($orderData['reference']);

            $manager->persist($order);

            $this->addReference($orderData['reference'], $order);
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
