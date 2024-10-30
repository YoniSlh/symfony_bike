<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeloController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/velos', name: 'velos')]
    public function list(): Response
    {
        $velos = $this->productRepository->findAll();

        return $this->render('velos_list.html.twig', [
            'velos' => $velos,
        ]);
    }

    #[Route('/velos/show/{id}', name: 'velos_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $velo = $this->productRepository->find($id);
        $velos = $this->productRepository->findAll();

        if (!$velo) {
            throw $this->createNotFoundException('Le vélo demandé n\'existe pas.');
        }

        return $this->render('velos_show.html.twig', [
            'velo' => $velo,
            'velos' => $velos,
        ]);
    }
}
