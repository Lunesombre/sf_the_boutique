<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_products_crud_list')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_product')]
    public function delete(
        Product $product,
        ProductRepository $productRepository
    ): Response {
        $productRepository->remove($product, true);
        $this->addFlash('success', 'Article ' . $product->getName() . ' supprimé conformément à votre demande.');
        return $this->redirectToRoute('admin_products_crud_list');
    }

    #[Route('/edit/{id}', name: 'edit_product')]
    public function edit(
        Product $product,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Article mis à jour');
            return $this->redirectToRoute('admin_products_crud_list');
        }
        return $this->renderForm('admin/edit.html.twig', [
            'form' => $form
        ]);
    }
    
    #[Route('/{id\d+}', name: 'admin_product_detail')]
    // le \d+ permet de lui dire que j'attend un entier positif, si symfony trouve autre chose, comme la string 'create' ou bien 'new', il va aller chercher ailleurs ce qu'est cette chose plutôt que chercher un produit d'id "create". L'autre solution c'est de passer cette route à la fin, en dessous du create.

    public function item(Product $product): Response
    {
        return $this->render('admin/detail.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/create', name: 'create_product')]
    public function create(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDateCreated(new DateTime());
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Article crée ! Félicitations, beau bébé.');
            return $this->redirectToRoute('admin_products_crud_list');
        }
        return $this->renderForm('admin/create.html.twig', [
            'form' => $form
        ]);
    }

}
