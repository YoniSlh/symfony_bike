<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VeloController extends AbstractController
{
    private ProductRepository $productRepository;
    private AvisRepository $avisRepository;

    public function __construct(ProductRepository $productRepository, AvisRepository $avisRepository)
    {
        $this->productRepository = $productRepository;
        $this->avisRepository = $avisRepository;
    }

    #[Route('/velos', name: 'velos')]
    public function list(Request $request): Response
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

        if (!$velo) {
            throw $this->createNotFoundException('Le vélo demandé n\'existe pas.');
        }

        $avisVelos = $this->avisRepository->findBy(['product' => $velo]);
        $velos = $this->productRepository->findAll();

        return $this->render('velos_show.html.twig', [
            'velo' => $velo,
            'velos' => $velos,
            'avis' => $avisVelos,
        ]);
    }
}
