<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
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
                    'placeholder' => "Your First Name"
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
                    'placeholder' => "Your Last Name"
                ]
                ])
            ->add('phone', TelType::class, [
                'required' => true,
                'invalid_message' => 'Enter valid Phone Number',
                'label' => 'Phone',
                'constraints' => [new Length([
                    'min' => 2,
                    'max' => 20
                ])],
                'attr' => [
                    'placeholder' => "Your Phone"
                ]
                ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'E-mail',
                'constraints' => [new Length([
                    'min' => 2,
                    'max' => 20
                ])],
                'invalid_message' => 'Enter valid E-mail',
                'attr' => ['placeholder' => "Your E-mail"]
                ])
            ->add('password', RepeatedType::class, [
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
