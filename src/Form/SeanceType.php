<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Seance;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var App\Entity\User[] $coaches */
        $coaches = $options['coaches'];
        $builder
            ->add('adept', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
            ])
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'label',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
            'coaches' => []
        ]);
    }
}
