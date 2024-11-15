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
        $firstName = $request->request->get('_first_name');
        $lastName = $request->request->get('_last_name');
        $password = $request->request->get('_password');
        $confirmPassword = $request->request->get('_confirm_password');

        if (!$email || !$firstName || !$lastName || !$password || !$confirmPassword) {
            return $this->render('register.html.twig', [
                'controller_name' => 'LoginController',
            ]);
        }

        if ($password !== $confirmPassword) {
            return $this->render('register.html.twig', [
                'controller_name' => 'LoginController',
            ]);
        }

        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordHasher->hashPassword($user, $password));

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a bien été créé.');
        return $this->redirectToRoute('login');
    }
}
