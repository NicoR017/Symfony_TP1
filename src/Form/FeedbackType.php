<?php
// src/Form/FeedbackType.php

namespace App\Form;

use App\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomClient', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez fournir votre nom.']),
                ],
            ])
            ->add('emailClient', EmailType::class, [
                'label' => 'Votre adresse email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez fournir votre adresse email.']),
                    new Email(['message' => 'L\'adresse email "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('noteProduit', ChoiceType::class, [
                'label' => 'Évaluation du produit',
                'choices' => $this->getRatingChoices(),
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez fournir une évaluation.']),
                    new Range(['min' => 1, 'max' => 5, 'minMessage' => 'L\'évaluation doit être d\'au moins 1.', 'maxMessage' => 'L\'évaluation doit être au plus 5.']),
                ],
            ])
            ->add('commentaires', TextareaType::class, [
                'label' => 'Commentaires',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez fournir des commentaires.']),
                ],
            ])
            ->add('dateSoumission', null, ['label' => 'Date de soumission'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }

    private function getRatingChoices(): array
    {
        return [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
        ];
    }
}
