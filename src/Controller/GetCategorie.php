<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class GetCategorie extends AbstractController
{
    #[Route('/category/{id<\d+>}', name: 'category_show')]
    public function getCategorie(int $id){

        $category_id = $id;
        return $this->render('category.html.twig', [
            'id_category' => $category_id,
        ]);

    }


}