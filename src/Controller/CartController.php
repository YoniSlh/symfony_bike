<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function showCart(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir votre panier.');
        }

        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
            $em->flush();
        }

        return $this->render('panier.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add', name: 'cart_add', methods: ['POST'])]
    public function add(Request $request, ProductRepository $productRepository, EntityManagerInterface $em): RedirectResponse
    {
        $productId = $request->request->get('productId');
        $quantity = (int) $request->request->get('quantity', 1);
    
        $product = $productRepository->find($productId);
        if (!$product) {
            return new JsonResponse(['error' => 'Produit introuvable'], 404);
        }
    
        $cart = $this->getOrCreateCart($em);
        $cartItem = $cart->getCartItemForProduct($product);
    
        if ($cartItem) {
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cartItem->setCart($cart);
            $em->persist($cartItem);
        }
    
        $em->flush();
    
        return $this->redirectToRoute('cart');
    }
    
    private function getOrCreateCart(EntityManagerInterface $em): Cart
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir votre panier.');
        }

        $cart = $user->getCart();
        if (!$cart) {
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
        }

        return $cart;
    }
}
