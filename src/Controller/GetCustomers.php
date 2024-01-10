<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GetCustomers extends AbstractController
{
    #[Route('/customers', name: 'customers_list')]
    public function getCustomers(): Response
    {
        $customers = ['John', 'Laurent', 'Alain', 'Pierre'];
        // La logique pour récupérer les données des clients peut être ajoutée ici
        return $this->render('customer.html.twig', ['customers' => $customers]);
    }
}