<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{ 
    #[Route('/panier', name: 'cart_index')]
    public function index(): Response
    {
        return $this->render('cart.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
