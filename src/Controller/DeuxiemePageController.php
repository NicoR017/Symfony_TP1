<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeuxiemePageController extends AbstractController
{
    #[Route('/deuxiemePage', name: 'app_deuxieme_page')]
    public function index(): Response
    {
        return $this->render('deuxieme_page/index.html.twig', ['message' => 'Bienvenue sur ma première page Symfony!' ]);
    }

}
