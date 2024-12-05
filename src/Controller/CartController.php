<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

class CartController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    #[Route('/api/cart/add', name: 'api_cart_add', methods: ['POST'])]
    public function addToCart(Request $request): JsonResponse
    {
        $cart = $this->session->get('cart', []);

        $data = json_decode($request->getContent(), true);
        $productId = $data['id'] ?? null;
        $productName = $data['name'] ?? null;
        $productPrice = $data['price'] ?? null;

        if (!$productId || !$productName || !$productPrice) {
            return new JsonResponse(['error' => 'Invalid data'], 400);
        }

        if (!isset($cart[$productId])) {
            $cart[$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 0,
            ];
        }

        $cart[$productId]['quantity']++;

        $this->session->set('cart', $cart);

        return new JsonResponse([
            'cart' => $cart,
            'itemCount' => array_sum(array_column($cart, 'quantity')),
            'totalAmount' => array_reduce($cart, fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0),
        ]);
    }


    #[Route('/api/cart', name: 'api_cart_get', methods: ['GET'])]
    public function getCart(): JsonResponse
    {
        $cart = $this->session->get('cart', []);
        $itemCount = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_reduce($cart, fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0);

        return new JsonResponse([
            'cart' => $cart,
            'itemCount' => $itemCount,
            'totalAmount' => $totalAmount,
        ]);
    }


    #[Route('/cart', name: 'cart_show', methods: ['GET'])]
    public function showCart(): Response
    {
        $cart = $this->session->get('cart', []);

        return $this->render('cart.html.twig', [
            'cart' => $cart,
        ]);
    }
}
