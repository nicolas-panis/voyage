<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => "Mot de passe actuel :",
                'label_attr' => [
                    'class' => "block mb-2 text-base font-semibold text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'first_options' => [
                    'label' => "Nouveau mot de passe :",
                    'label_attr' => [
                        'class' => "block mb-2 text-base font-semibold text-gray-900"
                    ],
                    'attr' => [
                        'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    ] 
                ],
                'second_options' => [
                    'label' => "Répéter nouveau mot de passe :",
                    'label_attr' => [
                        'class' => "block mb-2 text-base font-semibold text-gray-900"
                    ],
                    'attr' => [
                        'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    ] 
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
