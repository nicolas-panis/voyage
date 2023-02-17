<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mes-articles', name: 'user_articles')]
    public function myArticle(): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findAll();

        return $this->render('user/myArticles.html.twig', [
            'articles' => $article,
        ]);
    }

    #[Route('/mon-compte', name: 'user_compte')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
}
