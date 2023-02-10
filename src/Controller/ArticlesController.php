<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Entity\Categories;
use App\Form\ArticlesType;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticlesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/articles', name: 'articles')]
    public function index(): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findAll();
        return $this->render('articles/index.html.twig', [
            'articles' => $article
        ]);
    }

    #[Route('/articles/ajouter', name: 'articles_add')]
    public function add(Request $request, SluggerInterface $slugger): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $article->setUser($this->getUser());
            $article->setCreatedAt(new \DateTime());
            $article->setUpdateAt(new \DateTime());
            $image = $form->get('image')->getData();
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move($this->getParameter('articles_directory'), $fichier);
            $article->setImage($fichier);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            return $this->redirectToRoute('articles');
        }
        return $this->render('articles/addArticles.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/{slug}', name: 'articles_show')]
    public function show(Request $request, $slug): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findOneBySlug($slug);

        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire->setUser($this->getUser());
            $commentaire->setArticles($article);
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setUpdateAt(new \DateTime());
            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            return $this->redirectToRoute('articles_show', [
                'slug' => $article->getSlug(),
            ]);
        }

        $commentaires = $this->entityManager->getRepository(Commentaires::class)->findAll();

        return $this->render('articles/showArticles.html.twig', [
            'articles' => $article,
            'form' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

    #[Route('/articles/{slug}/modification', name: 'articles_edit')]
    public function edit(Request $request, $slug): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findOneBySlug($slug);
        if (!$article && $article->getUser() != $this->getUser()){
            return $this->redirectToRoute('articles');
        }
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $article->setUpdateAt(new \DateTime());
            $this->entityManager->flush();
            return $this->redirectToRoute('articles_show', [
                'slug' => $article->getSlug(),
            ]);
            
        }
        return $this->render('articles/editArticles.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/{slug}/suppression', name: 'articles_delete')]
    public function delete(Request $request, $slug): Response
    {
        $article = $this->entityManager->getRepository(Articles::class)->findOneBySlug($slug);
        if ($article && $article->getUser() == $this->getUser()){
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('articles');
    }
}
