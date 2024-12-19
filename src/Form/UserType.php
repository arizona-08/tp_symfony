<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = [
            'Admin' => 'ROLE_ADMIN', 
            'Client' => 'ROLE_USER', 
            'Coach' => 'ROLE_COACH', 
            'Bannis' => 'ROLE_BANNED'
        ];
        $builder
            ->add('name')
            ->add('email')
            ->add('password')
            ->add('role', ChoiceType::class, [
                'choices' => $roles,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Rôle',
                'mapped' => false
            ])
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
