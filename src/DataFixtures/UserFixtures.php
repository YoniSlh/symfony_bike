<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['email' => 'user1@example.com', 'firstName' => 'Yoni', 'lastName' => 'Selhaoui', 'roles' => ['ROLE_USER'], 'password' => 'password1'],
            ['email' => 'user2@example.com', 'firstName' => 'John', 'lastName' => 'Doe', 'roles' => ['ROLE_ADMIN'], 'password' => 'password2'],
            ['email' => 'user3@example.com', 'firstName' => 'Sam', 'lastName' => 'Smith', 'roles' => ['ROLE_USER'], 'password' => 'password3'],
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setEmail($userData['email'])
                ->setFirstName($userData['firstName'])
                ->setLastName($userData['lastName'])
                ->setRoles($userData['roles']);

            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
