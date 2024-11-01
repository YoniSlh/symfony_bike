<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profil', name: 'user_profil')]
    public function index(): Response
    {
        return $this->render('profil.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/panier', name: 'user_panier')]
    public function panier(): Response
    {
        return $this->render('panier.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
