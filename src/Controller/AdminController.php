<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Product;

class AdminController extends AbstractController
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, OrderRepository $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        $products = $this->productRepository->findAll();

        return $this->render('admin.html.twig', [
            'users' => $users,
            'products' => $products,
        ]);
    }

    #[Route('/admin/delete/product/{id}', name: 'app_admin_deleteProduct')]
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/edit/product/{id}', name: 'app_admin_editProduct')]
    public function editProduct(Product $product, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setDescription($request->request->get('description'));
            $product->setStock($request->request->get('stock'));
            $product->setPoids($request->request->get('poids'));
            $product->setCouleur($request->request->get('couleur'));
            $product->setMarque($request->request->get('marque'));

            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('editProduct.html.twig', [
            'product' => $product
        ]);
    }
}
