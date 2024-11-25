<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CreditCard;

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

    #[Route('/profil', name: 'user_profil')]
    public function listCreditCards(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); 

        $creditCards = $entityManager->getRepository(CreditCard::class)->findBy([
            'user' => $user
        ]);

        return $this->render('profil.html.twig', [
            'controller_name' => 'UserController',
            'creditCards' => $creditCards,
        ]);
    }

    #[Route('/profil/addCreditCard', name: 'user_profil_addCreditCard')]
    public function addCreditCard(EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $card = new CreditCard();
            $card->setNumber($request->request->get('card_number'));
            $card->setExpirationDate(new \DateTime($request->request->get('expiration_date')));
            $card->setCvv($request->request->get('cvv'));
            $card->setUser($this->getUser());

            $entityManager->persist($card);
            $entityManager->flush();

            $this->addFlash('success', 'La carte bancaire a bien été ajoutée');
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('addCreditCard.html.twig');
    }
}
