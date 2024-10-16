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
            ['id' => 1, 'name' => 'Vélo de Montagne', 'type' => 'Tout-terrain', 'price' => 500, 'description' => 'Un vélo adapté aux terrains accidentés.', 'image' => 'https://www.cyclesloisirs.com/wp-content/uploads/2016/03/VTT-LAPIERRE-EDGE-217.jpg', 'stock' => 'En stock'],
            ['id' => 2, 'name' => 'Vélo de Route', 'type' => 'Sur route', 'price' => 700, 'description' => 'Un vélo conçu pour la vitesse sur les routes pavées.', 'image' => 'https://www.lexpertvelo.com/documents/Image/les-differents-type-velo-route-2.jpg', 'stock' => 'En rupture de stock'],
            ['id' => 3, 'name' => 'Vélo Hybride', 'type' => 'Mixte', 'price' => 600, 'description' => 'Un vélo polyvalent pour différents types de terrains.', 'image' => 'https://sunrider85.fr/wp-content/uploads/2020/06/Image-3-v%C3%A9lo.jpg', 'stock' => 'En stock'],
        ];

        return $this->render('velos_list.html.twig', [
            'velos' => $velos,
        ]);
    }

    #[Route('/velos/show/{id}', name: 'velos_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $velos = [
            1 => ['id' => 1, 'name' => 'Vélo de Montagne', 'type' => 'Tout-terrain', 'price' => 500, 'description' => 'Un vélo adapté aux terrains accidentés.', 'image' => 'https://www.cyclesloisirs.com/wp-content/uploads/2016/03/VTT-LAPIERRE-EDGE-217.jpg'],
            2 => ['id' => 2, 'name' => 'Vélo de Route', 'type' => 'Sur route', 'price' => 700, 'description' => 'Un vélo conçu pour la vitesse sur les routes pavées.', 'image' => 'https://www.lexpertvelo.com/documents/Image/les-differents-type-velo-route-2.jpg'],
            3 => ['id' => 3, 'name' => 'Vélo Hybride', 'type' => 'Mixte', 'price' => 600, 'description' => 'Un vélo polyvalent pour différents types de terrains.', 'image' => 'https://sunrider85.fr/wp-content/uploads/2020/06/Image-3-v%C3%A9lo.jpg'],
        ];

        if (!isset($velos[$id])) {
            throw $this->createNotFoundException('Le vélo demandé n\'existe pas.');
        }

        return $this->render('velos_show.html.twig', [
            'velo' => $velos[$id],
        ]);
    }
}
