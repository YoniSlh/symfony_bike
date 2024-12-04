<?php

namespace App\Controller;

use App\Form\ProductAutocompleteField;
use App\Form\ProductAutocomplete;
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
        $form = $this->createForm(ProductAutocomplete::class);
        $form->handleRequest($request);

        $velos = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $searchQuery = $form->getData()['search'];
            $velos = $this->productRepository->findBy(['name' => $searchQuery]);
        } else {
            $velos = $this->productRepository->findAll();
        }

        return $this->render('velos_list.html.twig', [
            'velos' => $velos,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/velos/autocomplete', name: 'velos_autocomplete', methods: ['GET'])]
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->query->get('query', '');
        $results = $this->productRepository->findBy(['name' => $query]);

        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'id' => $result->getId(),
                'name' => $result->getName(),
            ];
        }

        return new JsonResponse($data);
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
