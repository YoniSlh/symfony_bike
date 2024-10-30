<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $velos = $this->productRepository->findBy([], null, 3);

        return $this->render('home.html.twig', [
            'velos' => $velos,
        ]);
    }
}
