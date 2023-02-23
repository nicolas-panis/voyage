<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Articles;
use App\Form\InformationChangeType;
use App\Form\PasswordChangeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-compte', name: 'user_compte')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
    
    #[Route('/mon-compte/modifier-mes-informations', name: 'user_change_info')]
    public function editUser(Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(InformationChangeType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();

            // $mail = new Mail();
            // $subject = 'Vos informations ont bien été mis à jour';
            // $content = "Bonjour ".$user->getLogin()." vos informations viennent d'être mis à jour avec succès.";
            // $mail->sendInformation($user->getEmail(), $user->getLogin(), $subject, $content);

            return $this->redirectToRoute('user_compte');
        }

        return $this->render('user/informationChange.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/mon-compte/changement-mot-de-passe', name: 'user_change_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(PasswordChangeType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_password)){
                $new_password = $form->get('new_password')->getData();
                $hashedPassword = $encoder->hashPassword($user, $new_password);
                $user->setPassword($hashedPassword); 
                
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                // $mail = new Mail();
                // $subject = 'Votre mot de passe à bien été changé';
                // $content = "Bonjour ".$user->getLogin()." votre mot de passe vient d'être mis à jour avec succès.";
                // $mail->sendPassword($user->getEmail(), $user->getLogin(), $subject, $content);

                return $this->redirectToRoute('user_compte');
            }
        }
        return $this->render('user/PasswordChange.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
