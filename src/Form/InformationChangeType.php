<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'label' => "Login",
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => "text-white bg-gradient-to-r from-emerald-700 via-emerald-800 to-emerald-900 hover:bg-gradient-to-l  font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 w-full"
                ]
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
