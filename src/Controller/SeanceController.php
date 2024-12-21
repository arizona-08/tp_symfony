<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\ExerciceRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeanceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seance')]
final class SeanceController extends AbstractController
{
    #[Route(name: 'app_seance_index', methods: ['GET'])]
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, ExerciceRepository $exerciceRepository): Response
    {
        $seance = new Seance();

        /** @var App\Entity\User[] $coaches */
        $coaches = $this->getCoaches($userRepository);
        
        $clients = $this->getClients($userRepository);

        /** @var App\Entity\Exercice[] $exercices */
        $exercices = $clients[0]->getProgram()->getExercices();
    
        $client = null;
        $queryClientId = $request->query->get('client');
        if($queryClientId){

            /** @var App\Entity\User|null $selectedClient */
            $client = $userRepository->find($queryClientId);
            $exercices = $client->getProgram()->getExercices();
            if (!$client) {
                throw $this->createNotFoundException('Client not found');
            }
            // dd($client);
        }
        
        $form = $this->createForm(SeanceType::class, $seance, [
            'clients' => $clients,
            'coaches' => $coaches,
            'exercices' => $exercices,
            'selected_client' => $client,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $seance->setAdept($userRepository->find($request->get('seance')['client']));
            foreach ($request->get('seance')['exercices'] as $exercice_id) {
                $seance->addExercice($exerciceRepository->find($exercice_id));
            }
            
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seance_show', methods: ['GET'])]
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seance $seance, EntityManagerInterface $entityManager, UserRepository $userRepository, ExerciceRepository $exerciceRepository): Response
    {
        $coaches = $this->getCoaches($userRepository);
        $clients = $this->getClients($userRepository);

        /** @var App\Entity\Exercice[] $exercices */
        $exercices = $exerciceRepository->findAll();
        $form = $this->createForm(SeanceType::class, $seance, [
            'clients' => $clients,
            'coaches' => $coaches,
            'exercices' => $exercices
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $seance->setAdept($userRepository->find($request->get('seance')['client']));
            foreach ($request->get('seance')['exercices'] as $exercice_id) {
                $seance->addExercice($exerciceRepository->find($exercice_id));
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seance_delete', methods: ['POST'])]
    public function delete(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/validate', name: 'app_seance_validate', methods: ['POST'])]
    public function validate(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('validate'.$seance->getId(), $request->getPayload()->getString('_token'))) {
            // dd($request);
            $seance->setValidated(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seance_show', ['id' => $seance->getId()], Response::HTTP_SEE_OTHER);
    }

    public function getCoaches(UserRepository $userRepository){
        $users = $userRepository->findAll();

        $coaches = [];

        foreach ($users as $key => $user) {
            if(in_array('ROLE_COACH', $user->getRoles())){
                $coaches[] = $user;
            }
        }

        return $coaches;
    }

    public function getClients(UserRepository $userRepository){
        $users = $userRepository->findAll();

        $clients = [];

        foreach ($users as $key => $user) {
            if(in_array('ROLE_USER', $user->getRoles())){
                $clients[] = $user;
            }
        }

        return $clients;
    }
}
