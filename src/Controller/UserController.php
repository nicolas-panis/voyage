<?php

namespace App\Controller;

use App\Entity\Articles;
//use App\Entity\Avatar;
use App\Form\AvatarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        // $avatar = $this->entityManager->getRepository(Avatar::class)->findAll();
        return $this->render('user/index.html.twig');
    }

    // #[Route('/mon-compte/ajouter-un-avatar', name: 'user_addAvatar')]
    // public function addAvatar(Request $request): Response
    // {
    //     //$avatar = new Avatar();
    //     $form = $this->createForm(AvatarType::class, $avatar);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()){
    //         $avatar->setUser($this->getUser());
    //         $image = $form->get('image')->getData();
    //         $fichier = md5(uniqid()) . '.' . $image->guessExtension();
    //         $image->move($this->getParameter('avatar_directory'), $fichier);
    //         $avatar->setImage($fichier);
    //         $this->entityManager->persist($avatar);
    //         $this->entityManager->flush();
    //         return $this->redirectToRoute('user_compte');
    //     }
    //     return $this->render('user/addAvatar.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    // #[Route('/mon-compte/modifier-avatar/{id}', name: 'user_editAvatar')]
    // public function editAvatar(Request $request, $id): Response
    // {
    //     $avatar = $this->entityManager->getRepository(Avatar::class)->find($id);
    //     $form = $this->createForm(AvatarType::class, $avatar);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()){
    //         $image = $form->get('image')->getData();
    //         $fichier = md5(uniqid()) . '.' . $image->guessExtension();
    //         $image->move($this->getParameter('avatar_directory'), $fichier);
    //         $avatar->setImage($fichier);
    //         $this->entityManager->flush();
    //         return $this->redirectToRoute('user_compte');
    //     }
    //     return $this->render('user/editAvatar.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    // #[Route('/mon-compte/supprimer-avatar/{id}', name: 'user_deleteAvatar')]
    // public function deleteAvatar(Request $request, $id): Response
    // {
    //     $avatar = $this->entityManager->getRepository(Avatar::class)->find($id);
    //     $this->entityManager->remove($avatar);
    //     $this->entityManager->flush();
    //     return $this->redirectToRoute('mon-compte');
    // }
}
