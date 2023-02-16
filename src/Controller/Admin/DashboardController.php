<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArticlesCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Travel Stars');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if($this->isGranted('ROLE_SUPER_ADMIN') || $this->isGranted('ROLE_ADMIN')){
            yield MenuItem::linkToCrud('User', 'fas fa-users', User::class);
        }

        yield MenuItem::section('Articles');
        yield MenuItem::subMenu('Articles', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles', '', Articles::class)->setAction('index'),
            MenuItem::linkToCrud('Ajouter un article','', Articles::class)->setAction('new'),
        ]);
        
        yield MenuItem::subMenu('Categories', 'fa-solid fa-tags')->setSubItems([
            MenuItem::linkToCrud('Mes catégories','', Categories::class)->setAction('index'),
            MenuItem::linkToCrud('Ajouter une catégorie','', Categories::class)->setAction('new'),

        ]);
    }
}
