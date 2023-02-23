<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagePersoController extends AbstractController
{
    #[Route('/namibie', name: 'articles_namibie')]
    public function index(): Response
    {
        return $this->render('page_perso/namibia.html.twig');
    }

    #[Route('/australie', name: 'articles_australie')]
    public function australie(): Response
    {
        return $this->render('page_perso/australie.html.twig');
    }
    
    
    #[Route('/notre-equipe', name: 'equipe')]
    public function Equipe(): Response
    {
        return $this->render('page_perso/equipe.html.twig');
    }
}
