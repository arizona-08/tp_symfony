<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Program;
use App\Entity\Seance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Symfony\Component\Clock\now;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->hasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $users = $this->createUsers($manager);
        $programs = $this->createPrograms($manager);
        $exercices = $this->createExercices($manager);
        $this->linkClientToPrograms($users, $programs, $manager);
        $this->linkExercicesToPrograms($programs, $exercices, $manager);

        $seances = $this->createSeances($manager, $users);


        $manager->flush();
    }

    public function createUsers(ObjectManager $manager){
        $users = [
            "Administrateur" => [
                'role' => "ROLE_ADMIN",
                'email' => "admin@test.com",
                'password' => "coucou",
                'program' => null
            ],

            "Coach 1" => [
                'role' => "ROLE_COACH",
                'email' => "coach1@test.com",
                'password' => "coucou",
                'program' => null
            ],

            "Coach 2" => [
                'role' => "ROLE_COACH",
                'email' => "coach2@test.com",
                'password' => "coucou",
                'program' => null
            ],

            "Client 1" => [
                'role' => "ROLE_USER",
                'email' => "client1@test.com",
                'password' => "coucou",
            ],

            "Client 2" => [
                'role' => "ROLE_USER",
                'email' => "client2@test.com",
                'password' => "coucou",
            ],

            "Client 3" => [
                'role' => "ROLE_USER",
                'email' => "client3@test.com",
                'password' => "coucou",
            ],
            "Client bannis" => [
                'role' => "ROLE_BANNED",
                'email' => "banned@test.com",
                'password' => "coucou",
            ],
        ];

        $persistedUsers = [];
        foreach ($users as $userName => $userProps) {
            $user = new User();
            $user->setName($userName);
            $user->setRoles([$userProps['role']]);
            $user->setEmail($userProps['email']);

            $hashedPassword = $this->hasher->hashPassword($user, $userProps['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);

            $persistedUsers[] = $user;
        }

        return $persistedUsers;
    }

    public function createPrograms(ObjectManager $manager){
        $programs = ["Programme débutant", "Programme amateur", "Programme athlète"];
        $persistedPrograms = [];

        foreach($programs as $program){
            $programObject = new Program();
            $programObject->setLabel($program);
            $manager->persist($programObject);

            $persistedPrograms[] = $programObject;
        }

        return $persistedPrograms;
    }

    public function createExercices(ObjectManager $manager){
        $exercices = [
            'Pompes simples', 
            'Pompes prise large', 
            'Pompe diamand', 
            'Crunchs', 
            'Sit-ups', 
            'Gainange', 
            'Russian twists',
            'Squats',
            'Flexions',
            'Burpees',
            'Jumping Jacks'
        ];

        $persistedExercices = [];

        foreach($exercices as $exercice){
            $exerciceObject = new Exercice();
            $exerciceObject->setLabel($exercice);
            $manager->persist($exerciceObject);
            $persistedExercices[] = $exerciceObject;
        }

        return $persistedExercices;
    }

    public function linkClientToPrograms(
        &$users, 
        &$programs,
        ObjectManager $manager
    ){
        $clients = [];
        foreach ($users as $user) {
            if($user->getUniqueRole() == 'ROLE_USER'){
                $clients[] = $user;
            }
        }

        foreach($clients as $client){
            $randomKey = array_rand($programs, 1);
            $client->setProgram($programs[$randomKey]);

            $manager->persist($client);
        }


    }

    public function linkExercicesToPrograms(
        &$programs,
        &$exercices,
        ObjectManager $manager
    ){
        foreach($exercices as $exercice){
            $randomKey = array_rand($programs);
            $exercice->addProgram($programs[$randomKey]);
            $manager->persist($exercice);
        }
    }

    public function createSeances(ObjectManager $manager, $users){
        $clients = [];
        $coaches = [];

        foreach($users as $user){
            if($user->getUniqueRole() == 'ROLE_USER'){
                $clients[] = $user;
            }

            if($user->getUniqueRole() == 'ROLE_COACH'){
                $coaches[] = $user;
            }
        }

        foreach ($clients as $client) {
            for($i = 0; $i < 3; $i++){
                $seance = new Seance();
                $seance->setAdept($client);
                $seance->setCoach($coaches[array_rand($coaches)]);
                $seance->setSeanceDate(now());
                $seance->setValidated(false);

                $program = $client->getProgram();
                $exercices = $program->getExercices();

                foreach($exercices as $exercice){
                    $seance->addExercice($exercice);
                }

                $manager->persist($seance);
            }
        }
    }
}
