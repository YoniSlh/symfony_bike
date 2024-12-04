<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $orderItemsData = [
            [
                'order_ref' => 'ORDER-001',
                'product_ref' => 'product_1',
                'quantity' => 1,
                'productPrice' => 7599.00,
            ],
            [
                'order_ref' => 'ORDER-002',
                'product_ref' => 'product_2',
                'quantity' => 1,
                'productPrice' => 4899.00,
            ],
            [
                'order_ref' => 'ORDER-003',
                'product_ref' => 'product_3',
                'quantity' => 1,
                'productPrice' => 5450.00,
            ],
        ];

        foreach ($orderItemsData as $itemData) {
            $orderItem = new OrderItem();

            $order = $this->getReference($itemData['order_ref'], Order::class);
            $product = $this->getReference($itemData['product_ref'], Product::class);

            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($itemData['quantity']);
            $orderItem->setProductPrice($itemData['productPrice']);

            $manager->persist($orderItem);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrderFixtures::class,
            ProductFixtures::class,
        ];
    }
}
