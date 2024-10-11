<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeloController extends AbstractController
{
    #[Route('/velos', name: 'velos')]
    public function list(): Response
    {
        $velos = [
            ['id' => 1, 'name' => 'Vélo de Montagne', 'type' => 'Tout-terrain', 'price' => 500, 'description' => 'Un vélo adapté aux terrains accidentés.'],
            ['id' => 2, 'name' => 'Vélo de Route', 'type' => 'Sur route', 'price' => 700, 'description' => 'Un vélo conçu pour la vitesse sur les routes pavées.'],
            ['id' => 3, 'name' => 'Vélo Hybride', 'type' => 'Mixte', 'price' => 600, 'description' => 'Un vélo polyvalent pour différents types de terrains.'],
        ];

        return $this->render('velos_list.html.twig', [
            'velos' => $velos,
        ]);
    }

    #[Route('/velos/show/{id}', name: 'velos_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $velos = [
            1 => ['id' => 1, 'name' => 'Vélo de Montagne', 'type' => 'Tout-terrain', 'price' => 500, 'description' => 'Un vélo adapté aux terrains accidentés.'],
            2 => ['id' => 2, 'name' => 'Vélo de Route', 'type' => 'Sur route', 'price' => 700, 'description' => 'Un vélo conçu pour la vitesse sur les routes pavées.'],
            3 => ['id' => 3, 'name' => 'Vélo Hybride', 'type' => 'Mixte', 'price' => 600, 'description' => 'Un vélo polyvalent pour différents types de terrains.'],
        ];

        if (!isset($velos[$id])) {
            throw $this->createNotFoundException('Le vélo demandé n\'existe pas.');
        }

        return $this->render('velos_show.html.twig', [
            'velo' => $velos[$id],
        ]);
    }
}
