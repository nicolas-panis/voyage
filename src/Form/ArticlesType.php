<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre",
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-2"
                ] 
            ])

            ->add('image', FileType::class, [
                'label' => "Image",
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"                        
                ],
                'mapped' => false,
                'multiple' => false,
                'attr' => [
                    'class' => "rounded-full"
                ]  
            ])

            ->add('content', TextareaType::class, [
                'label' => "Contenu",
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])

            ->add('country', CountryType::class, [
                'label' => "Pays :",
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])

            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Publier",
                'attr' => [
                    'class' => "text-white bg-gradient-to-r from-emerald-700 via-emerald-800 to-emerald-900 hover:bg-gradient-to-l  font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 w-full"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
