<?php

namespace App\Form;

use App\Entity\UserAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Length;

class UpdateAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Address', TextType::class, [
                'required' => true,

            ])
            ->add('State', TextType::class, [
                'required' => true,
            ])
            ->add('City', TextType::class, [
                'required' => true,
            ])
            ->add('ZipCode', IntegerType::class, [
                'required' => true,
                'constraints' => [ 
                    new Length([
                        'min' => 2,
                        'max' => 6
                    ])
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAddress::class,
        ]);
    }
}
