<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
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
        $creditCards = $entityManager->getRepository(CreditCard::class)->findBy(['user' => $user]);

        return $this->render('profil.html.twig', [
            'creditCards' => $creditCards,
        ]);
    }

    #[Route('/profil/addCreditCard', name: 'user_profil_addCreditCard')]
    public function addCreditCard(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $card = new CreditCard();
            $card->setNumber($request->request->get('card_number'));
            $card->setExpirationDate(new \DateTime($request->request->get('expiration_date')));
            $card->setCvv($request->request->get('cvv'));
            $card->setUser($this->getUser());

            $entityManager->persist($card);
            $entityManager->flush();

            $this->addFlash('success', 'La carte bancaire a bien été ajoutée.');
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('addCreditCard.html.twig');
    }

    #[Route('/profil/editCreditCard/{id}', name: 'user_profil_editCreditCard')]
    public function editCreditCard(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $card = $entityManager->getRepository(CreditCard::class)->find($id);
        if (!$card || $card->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('user_profil');
        }

        if ($request->isMethod('POST')) {
            $card->setNumber($request->request->get('card_number'));
            $card->setExpirationDate(new \DateTime($request->request->get('expiration_date')));
            $card->setCvv($request->request->get('cvv'));

            $entityManager->flush();

            $this->addFlash('success', 'La carte bancaire a bien été modifiée.');
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('editCreditCard.html.twig', [
            'card' => $card,
        ]);
    }

    #[Route('/profil/deleteCreditCard/{id}', name: 'user_profil_deleteCreditCard')]
    public function deleteCreditCard(int $id, EntityManagerInterface $entityManager): Response
    {
        $card = $entityManager->getRepository(CreditCard::class)->find($id);
        if ($card && $card->getUser() === $this->getUser()) {
            $entityManager->remove($card);
            $entityManager->flush();
        }

        $this->addFlash('success', 'La carte bancaire a bien été supprimée.');
        return $this->redirectToRoute('user_profil');
    }
}
