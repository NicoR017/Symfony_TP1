<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomClient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email(message: "L'adresse email '{{ value }}' n'est pas valide.")]
    private ?string $emailClient = null;

    #[ORM\Column(length: 255)]
    private ?string $noteProduit = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaires = null;

    #[ORM\Column(length: 255)]
    private ?string $dateSoumission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): static
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getNoteProduit(): ?string
    {
        return $this->noteProduit;
    }

    public function setNoteProduit(string $noteProduit): static
    {
        $this->noteProduit = $noteProduit;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getDateSoumission(): ?string
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(string $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;

        return $this;
    }
}
