<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="products")
     */
    public function index(Request $request)
    {
        $searchTerm = $request->query->get('search', '');
        $products = $this->productRepository->findBySearchTerm($searchTerm);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'searchTerm' => $searchTerm,
        ]);
    }
}
