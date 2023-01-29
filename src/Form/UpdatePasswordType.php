<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('old_password', PasswordType::class,[
            'required' => true,
            'mapped' => false,
            'attr' => [
                'placeholder' => "Enter your actual password"
            ]
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'invalid_message' => 'Repeated Password is not correct',
            'first_options'  => ['label' => 'Password',
            'attr' => [
                'placeholder' => "Your Password"
            ]],
            'second_options' => ['label' => 'Repeat Password',
            'attr' => [
                'placeholder' => "Repeat Your Password"
            ]],
        ] );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
