<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [

            AssociationField::new('user'),

            TextField::new('title', 'Titre'),

            ImageField::new('image', 'Couverture')
                ->setBasePath('uploads/articles')
                ->setUploadDir('public/uploads/articles')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true),

            TextareaField::new('content', 'Contenu'),

            AssociationField::new('categories'),

            CollectionField::new('commentaires')
                ->setEntryType(CommentairesType::class)
                ->allowAdd(false)
                ->allowDelete(false)
                ->onlyOnForms()
                ->hideWhenCreating(),

            DateTimeField::new('createdAt', 'Ajouté le')
                ->setFormat('dd.MM.yyyy')
                ->hideOnForm(),
                
            DateTimeField::new('updateAt', 'Modifié le')
                ->setFormat('dd.MM.yyyy')
                ->hideOnForm(),
            
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {


        $time = $entityInstance;

        $time->setCreatedAt(new \DateTime());
        $time->setUpdateAt(new \DateTime());
        
        parent::persistEntity($entityManager, $entityInstance);
    }
    
}
