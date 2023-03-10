<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::EDIT, 'ROLE_ADMIN');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un article')
            ->setPageTitle(Crud::PAGE_INDEX, 'Tous les articles')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier article');
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

            CountryField::new('country', 'Pays'),
            
            AssociationField::new('categories'),

            CollectionField::new('commentaires')
                ->setEntryType(CommentairesType::class)
                ->allowAdd(false)
                ->allowDelete(false)
                ->onlyWhenUpdating(),

            DateTimeField::new('createdAt', 'Ajout?? le')
                ->setFormat('dd.MM.yyyy')
                ->hideOnForm(),
                
            DateTimeField::new('updateAt', 'Modifi?? le')
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
