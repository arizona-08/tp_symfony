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

        /** @var App\Entity\Exercice[] $exercices */
        $exercices = $options['exercices'];

        $builder
            ->add('adept', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'label' => 'Client'
            ])
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'label',
                'label' => 'Programme'
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
            'coaches' => [],
            'exercices' => []
        ]);
    }
}
