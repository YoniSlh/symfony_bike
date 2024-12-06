<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $session;
    private $imageRepository;

    public function __construct(RequestStack $requestStack, ImageRepository $imageRepository)
    {
        $this->session = $requestStack->getSession();
        $this->imageRepository = $imageRepository;
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
        $images = [];

        foreach ($cart as $productId => $item) {
            $imageEntity = $this->imageRepository->findOneBy(['product' => $productId]);
            $images[$productId] = $imageEntity ? $imageEntity->getUrls()[0] : null;
        }

        return $this->render('cart.html.twig', [
            'cart' => $cart,
            'images' => $images,
        ]);
    }

    #[Route('/cart/remove', name: 'remove_from_cart', methods: ['POST'])]
    public function removeFromCart(Request $request, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productId = $data['id'] ?? null;

        if (!$productId) {
            return new JsonResponse(['error' => 'Produit introuvable'], 400);
        }

        $cart = $session->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);

            $session->set('cart', $cart);

            return new JsonResponse(['success' => true, 'removedProductId' => $productId]);
        }

        return new JsonResponse(['error' => 'Produit non trouvé dans le panier'], 404);
    }
}
