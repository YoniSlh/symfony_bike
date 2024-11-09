<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(Request $request): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $email = $request->request->get('_username');
        $password = $request->request->get('_password');
        $confirmPassword = $request->request->get('_confirm_password');

        if ($password !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            return $this->redirectToRoute('register');
        }

        $encodedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setEmail($email);
        $user->setPassword($encodedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
        return $this->redirectToRoute('login');
    }
}
