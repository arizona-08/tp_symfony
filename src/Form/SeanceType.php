<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\Program;
use App\Entity\Seance;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var App\Entity\User[] $coaches */
        $coaches = $options['coaches'];

        /** @var App\Entity\User[] $coaches */
        $clients = $options['clients'];

        /** @var App\Entity\User|null $selectedClient */
        $selectedClient = $options['selected_client'];

        /** @var App\Entity\Exercice[] $exercices */
        $exercices = $options['exercices'];
        // dd($selectedClient);
        
        $builder
            ->add('client', ChoiceType::class, [
                'choices' => $clients,
                'choice_value' => 'id',
                'choice_label' => function (?User $user): string {
                    return $user->getName();
                },
                'multiple' => false,
                'label' => 'Client',
                'mapped' => false,
                'data' => $selectedClient ?? $clients[0]
            ])
            ->add('exercices', ChoiceType::class, [
                'choices' => $exercices,
                'choice_value' => 'id',
                'choice_label' => function (?Exercice $exercice): string {
                    return $exercice->getLabel();
                },
                'expanded' => false,
                'multiple' => true,
                'label' => 'Exercices',
                'mapped' => false,
            ])
            ->add('coach', ChoiceType::class, [
                'choices' => $coaches,
                'choice_value' => 'id',
                'choice_label' => function (?User $user): string {
                    return $user->getName();
                },
                'expanded' => false,
                'multiple' => false,
                'label' => 'Coach'
            ])
            ->add('seanceDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de la séance',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
            'clients' => [],
            'coaches' => [],
            'exercices' => [],
            'selected_client' => null
        ]);
    }
}
