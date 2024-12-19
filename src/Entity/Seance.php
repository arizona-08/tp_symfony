<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $adept = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Program $program = null;

    #[ORM\ManyToOne(inversedBy: 'coachSeances')]
    private ?User $coach = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdept(): ?User
    {
        return $this->adept;
    }

    public function setAdept(?User $adept): static
    {
        $this->adept = $adept;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): static
    {
        $this->program = $program;

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(?User $coach): static
    {
        $this->coach = $coach;

        return $this;
    }
}
