<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Entity\UserFidelityPoints;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/register', name: 'app_register')]
    public function index(UserPasswordHasherInterface $hash, Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
           $password = $hash->hashPassword($user, $user->getPassword());
           $user->setPassword($password);

           $fidelitypoints = new UserFidelityPoints();
           $fidelitypoints->setPoints(0);
           $fidelitypoints->setUser($user);


           $this->em->persist($fidelitypoints);
           $this->em->persist($user);
           $this->em->flush();

           $this->addFlash('success', "Your are registered");
           return $this->redirectToRoute("app_home");
           
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
