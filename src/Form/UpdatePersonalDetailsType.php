<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UpdatePersonalDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'required' => true,
            'invalid_message' => 'Enter valid First Name',
            'constraints' => [new Length([
                'min' => 2,
                'max' => 20
            ])],
            'label' => 'First Name',
            'attr' => [
                'placeholder' => "Your New First Name"
            ]
            ])
        ->add('lastname', TextType::class, [
            'required' => true,
            'invalid_message' => 'Enter valid Last Name',
            'constraints' => [new Length([
                'min' => 2,
                'max' => 20
            ])],
            'label' => 'Last Name',
            'attr' => [
                'placeholder' => "Your New Last Name"
            ]
            ])
        ->add('phone', TelType::class, [
            'required' => true,
            'invalid_message' => 'Enter valid Phone Number',
            'label' => 'Phone',
            'constraints' => [new Length(['min' => 2,'max' => 20])],
            'attr' => [
                'placeholder' => "Your New Phone"
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
