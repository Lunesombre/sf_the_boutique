<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list')]
    public function list(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products = $productRepository->findBy(['visible' => true]);
        $categories = $categoryRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    #[Route('/products/{id}', name: 'products_item')]
    public function itemCard(Product $product): Response
    {
        return $this->render('product/item.html.twig', [
            'product' => $product
        ]);
    }
}
