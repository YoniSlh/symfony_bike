<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Enum\OrderStatus;
use App\Repository\ProductRepository;

class OrderController extends AbstractController
{
    private $session;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    #[Route('/order', name: 'app_order')]
    public function index(ProductRepository $productRepository): Response
    {
        $cart = $this->getCart();

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = $productRepository->find($productId);

            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
                $total += $product->getPrice() * $item['quantity'];
            }
        }

        return $this->render('order.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    #[Route('/order/success/{reference}', name: 'order_success')]
    public function success(string $reference): Response
    {
        return $this->render('order_success.html.twig', [
            'reference' => $reference,
        ]);
    }

    #[Route('/order/confirm', name: 'order_confirm', methods: ['POST'])]
    public function confirmOrder(EntityManagerInterface $entityManager): Response
    {
        $cart = $this->getCart();

        if (empty($cart)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('cart_show');
        }

        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Veuillez vous connecter pour confirmer votre commande.');
            return $this->redirectToRoute('login');
        }

        $lastOrder = $entityManager->getRepository(Order::class)->findOneBy([], ['id' => 'DESC']);
        $nextOrderNumber = 'ORDER-' . str_pad($lastOrder ? $lastOrder->getId() + 1 : 1, 3, '0', STR_PAD_LEFT);

        $order = new Order();
        $order->setUser($user)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setStatus(OrderStatus::EN_PREPARATION)
            ->setPrice(array_reduce($cart, fn($total, $item) => $total + $item['price'] * $item['quantity'], 0))
            ->setReference($nextOrderNumber);

        foreach ($cart as $productId => $item) {
            $product = $entityManager->getRepository(Product::class)->find($productId);

            if (!$product || $product->getStock() < $item['quantity']) {
                $this->addFlash('error', sprintf("Le produit %s n'est pas disponible en quantité suffisante.", $item['name']));
                return $this->redirectToRoute('cart_show');
            }

            $orderItem = new OrderItem();
            $orderItem->setOrder($order)
                ->setProduct($product)
                ->setQuantity($item['quantity'])
                ->setProductPrice($product->getPrice());

            $entityManager->persist($orderItem);

            $product->setStock($product->getStock() - $item['quantity']);
        }

        $entityManager->persist($order);
        $entityManager->flush();

        $this->session->remove('cart');

        $this->addFlash('success', 'Votre commande a été confirmée avec succès.');

        return $this->redirectToRoute('order_success', ['reference' => $order->getReference()]);
    }
}
