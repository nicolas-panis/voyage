<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $PasswordHasher): Response
    {
        $user = new User();

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
            
            if(!$search_email){
                if($user->getEmail() == "backup@backuptravelstars.com"){
                $user->setRoles(['ROLE_SUPER_ADMIN']);
                }else if($user->getEmail() == "nicolas.panis@laplateforme.io" || $user->getEmail() == "hugo.canovas@laplateforme.io" || $user->getEmail() == "kamel.sarhihi@laplateforme.io"){
                    $user->setRoles(['ROLE_ADMIN']);
                }else{
                    $user->setRoles(['ROLE_USER']);
                }

                $hashedPassword = $PasswordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                // $mail = new Mail();
                // $subject = 'Merci de votre inscription chez nous !';
                // $content = 'Bienvenue '.$user->getlogin().' chez Travel Stars, le blog dédié aux voyages !';
                // $mail->send($user->getEmail(), $user->getLogin(), $subject, $content);
            }else{

            }
 
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}