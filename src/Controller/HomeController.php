<?php

namespace App\Controller;

use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SeanceRepository $seanceRepository): Response
    {
        /** @var $user App\Entity\User */
        $user = $this->getUser();
        $coachSeances = $this->getSeancesByCoach($seanceRepository);
        return $this->render('home/index.html.twig', [
            'user' => $user,
            'coachSeances' => $coachSeances
        ]);
    }

    public function getSeancesByCoach(SeanceRepository $seanceRepository): array{
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if($user){
            if($user->getUniqueRole() == 'ROLE_COACH'){
                $seances = $seanceRepository->findByCoach($user);
                return $seances;
            }
        }
        
        return [];
    }
}
