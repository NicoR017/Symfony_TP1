<?php
// src/Controller/ShowProducts.php
// src/Controller/ShowProducts.php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowProducts extends AbstractController
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/showProducts', name: 'products_list')]
    public function showProducts(Request $request): Response
    {
        $parametre = $request->query->get('product');
        // affichage du résultat
        dump($parametre);

        $products = $this->productRepository->findAll();

        return $this->render('product.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/addProduct', name: 'add_product')]
    public function addProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');

            return $this->redirectToRoute('products_list');
        }

        return $this->render('add_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
