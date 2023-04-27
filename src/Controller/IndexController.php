<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products=$productRepository->findAll();
        $categories = $categoryRepository->findAll();


        return $this->render('index/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
