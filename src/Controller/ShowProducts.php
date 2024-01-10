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
        // Constructeur de la classe, utilisé pour injecter les dépendances nécessaires.
        // $productRepository est utilisé pour accéder aux fonctionnalités de récupération des produits.
        // $entityManager est utilisé pour interagir avec la base de données.
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/showProducts', name: 'products_list')]
    public function showProducts(Request $request): Response
    {
        // Récupérer le paramètre 'product' de la requête (peut être utilisé pour filtrer les produits, s'il est utilisé dans le code)
        $parametre = $request->query->get('product');



        // Récupérer tous les produits depuis le repository
        $products = $this->productRepository->findAll();

        // Rendre la vue avec la liste des produits
        return $this->render('product.html.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/addProduct', name: 'add_product')]
    public function addProduct(Request $request): Response
    {
        // Créer une nouvelle instance de l'entité Product
        $product = new Product();

        // Créer un formulaire à partir de la classe ProductType et l'entité $product
        $form = $this->createForm(ProductType::class, $product);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le produit dans la base de données
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            // Ajouter un message flash ou rediriger vers une page de succès
            $this->addFlash('success', 'Produit ajouté avec succès !');

            // Rediriger vers la liste des produits (changer 'products_list' par le nom correct de votre route)
            return $this->redirectToRoute('products_list');
        }

        // Rendre la vue avec le formulaire
        return $this->render('add_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
