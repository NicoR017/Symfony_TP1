<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/feedback", name="app_feedback")
     */
    public function index(Request $request): Response
    {
        // Créer une nouvelle instance de l'entité Feedback
        $feedback = new Feedback();
        // Créer un formulaire à partir de la classe FeedbackType et l'entité $feedback
        $form = $this->createForm(FeedbackType::class, $feedback);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le feedback dans la base de données
            $this->entityManager->persist($feedback);
            $this->entityManager->flush();

            // Ajouter un message flash ou rediriger vers une page de succès
            $this->addFlash('success', 'Feedback soumis avec succès !');
            // Rediriger vers la page du formulaire de feedback pour réinitialiser le formulaire
            return $this->redirectToRoute('app_feedback');
        }

        // Rendre la vue avec le formulaire
        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route('/feedbacks', name='list_feedbacks')
     */
    public function listFeedbacks(FeedbackRepository $feedbackRepository): Response
    {
        // Récupérer tous les feedbacks depuis le repository
        $feedbacks = $feedbackRepository->findAll();

        // Rendre la vue avec la liste des feedbacks
        return $this->render('feedback/list_feedbacks.html.twig', [
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * @Route('/edit-feedback/{id}', name='edit_feedback')
     */
    public function editFeedback(Request $request, FeedbackRepository $feedbackRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le feedback à éditer en utilisant l'ID
        $feedback = $feedbackRepository->find($id);

        // Vérifier si le feedback existe
        if (!$feedback) {
            throw $this->createNotFoundException('Feedback non trouvé');
        }

        // Créer un formulaire à partir de la classe FeedbackType et l'entité $feedback
        $form = $this->createForm(FeedbackType::class, $feedback);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            // Ajouter un message flash ou rediriger vers une page de succès
            $this->addFlash('success', 'Feedback modifié avec succès !');

            // Rediriger vers la liste des feedbacks
            return $this->redirectToRoute('list_feedbacks');
        }

        // Rendre la vue avec le formulaire et le feedback à éditer
        return $this->render('feedback/edit_feedback.html.twig', [
            'form' => $form->createView(),
            'feedback' => $feedback,
        ]);
    }

    /**
     * @Route('/delete-feedback/{id}', name='delete_feedback')
     */
    public function deleteFeedback(Feedback $feedback, EntityManagerInterface $entityManager): Response
    {
        // Supprimer le feedback de la base de données
        $entityManager->remove($feedback);
        $entityManager->flush();

        // Ajouter un message flash ou rediriger vers une page de succès
        $this->addFlash('success', 'Feedback supprimé avec succès !');

        // Rediriger vers la liste des feedbacks
        return $this->redirectToRoute('list_feedbacks');
    }
}
