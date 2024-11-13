<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\ProductStatus;

class AdminController extends AbstractController
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;
    private CategoryRepository $categoryRepository;
    private ImageRepository $imageRepository;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, OrderRepository $orderRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageRepository = $imageRepository;
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
        $categories = $this->categoryRepository->findAll();
        $productStatus = ProductStatus::cases();

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setDescription($request->request->get('description'));
            $product->setStock($request->request->get('stock'));
            $product->setPoids($request->request->get('poids'));
            $product->setCouleur($request->request->get('couleur'));
            $product->setMarque($request->request->get('marque'));

            // $imageUrls = $request->request->get('images');
            // if (!is_array($imageUrls)) {
            //     $imageUrls = [$imageUrls];
            // }

            // $images = [];
            // foreach ($imageUrls as $imageUrl) {
            //     $image = new Image();
            //     $image->setUrls([$imageUrl]);
            //     $images[] = $image;
            // }
            // foreach ($images as $image) {
            //     $product->addImage($image);
            // }

            $status = $request->request->get('status');
            if (ProductStatus::tryFrom($status)) {
                $product->setStatus(ProductStatus::from($status));
            }

            $categoryId = $request->request->get('category');
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $product->setCategory($category);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('editProduct.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'productStatus' => $productStatus
        ]);
    }
    #[Route('/admin/addProduct', name: 'app_admin_addProduct')]
    public function addProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $productStatus = ProductStatus::cases();
        $product = new Product();

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setDescription($request->request->get('description'));
            $product->setStock($request->request->get('stock'));
            $product->setPoids($request->request->get('poids'));
            $product->setCouleur($request->request->get('couleur'));
            $product->setMarque($request->request->get('marque'));

            $categoryId = $request->request->get('category');
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $product->setCategory($category);
            }

            $status = $request->request->get('status');
            if (ProductStatus::tryFrom($status)) {
                $product->setStatus(ProductStatus::from($status));
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('addProduct.html.twig', [
            'categories' => $categories,
            'product' => $product,
            'productStatus' => $productStatus
        ]);
    }
}
