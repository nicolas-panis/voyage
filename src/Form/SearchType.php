<?php 

namespace App\Form;

use App\Classe\Search;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900 "
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])

            ->add('pays', CountryType::class, [
                'label' => false,
                'placeholder' => 'Choississez votre pays',
                'required' => false,
                'label_attr' => [
                    'class' => "block mb-2 text-sm font-medium text-gray-900"
                ],
                'attr' => [
                    'class' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                ] 
            ])

            ->add('category', EntityType::class, [
                'label' => false,
                'required' => false,
                'class'=> Categories::class,
                'multiple' => true,
                'expanded' => true,
                // 'label_attr' => [
                //     'class' => "block mb-2 text-sm font-medium text-gray-900"
                // ],
                'attr' => [
                    'class' => "grid grid-cols-2 text-sm",
                ] 
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => "text-white bg-gradient-to-r from-emerald-700 via-emerald-800 to-emerald-900 hover:bg-gradient-to-l font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}