<?php

namespace App\Controller;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowProducts extends AbstractController
{
   // public function showTemplate(){
   //     return $this->render('render.html.twig');
   // }
    #[Route('/showProducts', name: 'products_list')]
    public function showProducts(Request $request){
        $parametre = $request->query->get('product');
        //affichage du résultat
        dump($parametre);

        $products = [
            "produit1" => [
               "name"=>"Ordinateur",
               "price"=> 799.99
                ],
            "produit2" => [
                "name" => "Smartphone",
                "price" => 399.99
            ],
            "produit3" => [
                "name" => "Casque audio",
                "price" => 99.99
            ],
            "produit4" => [
                "name" => "Tablette",
                "price" => 299.99
            ]
        ];
        return $this->render('product.html.twig', [
            'products' => $products,
        ]);

    }

}