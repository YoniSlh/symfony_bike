<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VeloController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/velos', name: 'velos')]
    public function list(Request $request, ProductRepository $productRepository): Response
    {
        $velos = $this->productRepository->findAll();
        $query = $request->query->get('query', '');
        $products = $productRepository->findBySearchQuery($query);

        return $this->render('velos_list.html.twig', [
            'velos' => $velos,
            'products' => $products,
            'searchTerm' => $query,
        ]);
    }

    #[Route('/search', name: 'product_search')]
    public function search(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $query = $request->query->get('query', '');
        $products = $productRepository->findBySearchQuery($query);
    
        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
            ];
        }
    
        return new JsonResponse($result);
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
