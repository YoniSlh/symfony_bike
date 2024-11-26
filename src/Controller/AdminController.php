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
use App\Entity\OrderItem;
use Doctrine\Common\Collections\ArrayCollection;
use App\Enum\ProductStatus;

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
        $orders = $this->orderRepository->findAll();
        $categories = $this->categoryRepository->findAll();

        // Calcul du nombre de produits par catégorie
        $nbProductsByCategory = [];
        foreach ($categories as $category) {
            $nbProductsByCategory[$category->getCategoryName()] = 0;
        }

        foreach ($products as $product) {
            $category = $product->getCategory();
            $nbProductsByCategory[$category->getCategoryName()]++;
        }

        // Récupération des 5 dernières commandes
        $cinqDernieresCommandes = $this->orderRepository->findBy([], ['createdAt' => 'DESC'], 5);

        // Calcul du ratio de disponibilité des produits (en stock, en rupture, en précommande)
        $enStock = 0;
        $enRupture = 0;
        $enPrecommande = 0;
        foreach ($products as $product) {
            switch ($product->getStatus()) {
                case ProductStatus::DISPONIBLE:
                    $enStock++;
                    break;
                case ProductStatus::RUPTURE_DE_STOCK:
                    $enRupture++;
                    break;
                case ProductStatus::PRECOMMANDE:
                    $enPrecommande++;
                    break;
            }
        }

        $totalProduits = count($products);
        $ratioEnStock = ($totalProduits > 0) ? ($enStock / $totalProduits) * 100 : 0;
        $ratioEnRupture = ($totalProduits > 0) ? ($enRupture / $totalProduits) * 100 : 0;
        $ratioEnPrecommande = ($totalProduits > 0) ? ($enPrecommande / $totalProduits) * 100 : 0;

        // Calcul du montant total des ventes réalisées par mois sur les 12 derniers mois
        $ventesParMois = [];
        $dateMoinsUnAn = new \DateTime('-1 year');
        foreach ($orders as $order) {
            if ($order->getCreatedAt() >= $dateMoinsUnAn) {
                $mois = $order->getCreatedAt()->format('Y-m');
                if (!isset($ventesParMois[$mois])) {
                    $ventesParMois[$mois] = 0;
                }
                $ventesParMois[$mois] += $order->getPrice();
            }
        }

        $moisActuel = new \DateTime();
        for ($i = 0; $i < 12; $i++) {
            $mois = $moisActuel->format('Y-m');
            if (!isset($ventesParMois[$mois])) {
                $ventesParMois[$mois] = 0;
            }
            $moisActuel->modify('-1 month');
        }

        $montantTotalVentes = array_sum($ventesParMois);

        ksort($ventesParMois);

        return $this->render('admin.html.twig', [
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
            'nbProductsByCategory' => $nbProductsByCategory,
            'cinqDernieresCommandes' => $cinqDernieresCommandes,
            'totalProduits' => $totalProduits,
            'enStock' => $enStock,
            'enRupture' => $enRupture,
            'enPrecommande' => $enPrecommande,
            'ratioEnStock' => $ratioEnStock,
            'ratioEnRupture' => $ratioEnRupture,
            'ratioEnPrecommande' => $ratioEnPrecommande,
            'ventesParMois' => $ventesParMois, 
            'montantTotalVentes' => $montantTotalVentes
        ]);
    }

    #[Route('/admin/products', name: 'admin_products')]
    public function listProducts(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('admin_products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function listUsers(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin_users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/products/delete/product/{id}', name: 'app_admin_deleteProduct')]
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/products/editProduct/{id}', name: 'app_admin_editProduct')]
    public function editProduct(Product $product, EntityManagerInterface $entityManager, Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $productStatus = ProductStatus::cases();

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            if ($request->request->get('price') > 0)
                $product->setPrice($request->request->get('price'));
            else {
                $this->addFlash('error', 'Le prix doit être supérieur à 0€');
                return $this->redirectToRoute('app_admin_editProduct', ['id' => $product->getId()]);
            }
            $product->setDescription($request->request->get('description'));
            $product->setStock($request->request->get('stock'));
            if ($request->request->get('poids') > 0)
                $product->setPoids($request->request->get('poids'));
            else {
                $this->addFlash('error', 'Le poids doit être supérieur à 0');
                return $this->redirectToRoute('app_admin_editProduct', ['id' => $product->getId()]);
            }
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
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('editProduct.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'productStatus' => $productStatus
        ]);
    }

    #[Route('/admin/products/addProduct', name: 'app_admin_addProduct')]
    public function addProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $productStatus = ProductStatus::cases();
        $product = new Product();

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            if ($request->request->get('price') > 0)
                $product->setPrice($request->request->get('price'));
            else {
                $this->addFlash('error', 'Le prix doit être supérieur à 0€');
                return $this->redirectToRoute('app_admin_addProduct');
            }
            $product->setDescription($request->request->get('description'));
            $product->setStock($request->request->get('stock'));
            if ($request->request->get('poids') > 0)
                $product->setPoids($request->request->get('poids'));
            else {
                $this->addFlash('error', 'Le poids doit être supérieur à 0');
                return $this->redirectToRoute('app_admin_addProduct');
            }
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

            $this->addFlash('success', 'Le produit a bien été ajouté');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('addProduct.html.twig', [
            'categories' => $categories,
            'product' => $product,
            'productStatus' => $productStatus
        ]);
    }
}
