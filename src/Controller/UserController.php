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
    public function index(): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findAll();

        return $this->render('user/index.html.twig', [
            'articles' => $article,
        ]);
    }
}
