<?php

namespace App\Form;

use App\Entity\Commentaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "votre commentaire...",
                    'class' => "w-full rounded-lg"
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Publier",
                'attr' => [
                    'class' => "text-white bg-gradient-to-r from-emerald-700 via-emerald-800 to-emerald-900 hover:bg-gradient-to-l font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
