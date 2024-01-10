<?php
namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="app_feedback")
     */
    public function index(Request $request): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer les données soumises (par exemple, enregistrer dans la base de données)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();

            // Ajouter un message flash ou rediriger vers une page de succès
            $this->addFlash('success', 'Feedback soumis avec succès !');
            // Rediriger vers la page du formulaire de feedback pour réinitialiser le formulaire
            return $this->redirectToRoute('app_feedback');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getDoctrine()
    {
        return $this->getDoctrine();
    }
}