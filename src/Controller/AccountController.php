<?php

namespace App\Controller;

use App\Entity\UserAddress;
use App\Form\UpdateAddressType;
use App\Form\UpdatePasswordType;
use App\Form\UpdatePersonalDetailsType;
use App\Repository\UserAddressRepository;
use App\Repository\UserFidelityPointsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    #[Route('/account', name: 'app_account')]
    public function index(Request $request, UserPasswordHasherInterface $hash, UserRepository $user, UserFidelityPointsRepository $userFidelityPointsRepository, UserAddressRepository $userAddressRepository, UserPasswordHasherInterface $hasher): Response
    {   
        $currentuser = $this->getUser();

        //PERSONAL DETAILS
        $formPersonalDetails = $this->createForm(UpdatePersonalDetailsType::class, $currentuser);
        $formPersonalDetails->handleRequest($request);

        if($formPersonalDetails->isSubmitted() && $formPersonalDetails->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Personal Details Is Updated');
        }


        //CHANGE PASSWORD
        $formChangePassword = $this->createForm(UpdatePasswordType::class);
        $formChangePassword->handleRequest($request);

        if($formChangePassword->isSubmitted() && $formChangePassword->isValid()){
            $oldpassword = $formChangePassword->get('old_password')->getData();
            $user = $user->findOneBy(['email' => $currentuser->getEmail()]);

            if($hasher->isPasswordValid($user, $oldpassword)){
                

            $password = $formChangePassword->getViewData()->getPassword();
            $password = $hash->hashPassword($user, $password);
            $user->setPassword($password);

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Password Is Updated');
            }else{
                $this->addFlash('errors', 'Actual password is invalid');
            }
            
        }

        //ADD ADDRESS
        $userAddress = new UserAddress();
        $formAddAddress = $this->createForm(UpdateAddressType::class, $userAddress);
        $formAddAddress->handleRequest($request);

        if($formAddAddress->isSubmitted() && $formAddAddress->isValid()){
            
            $userAddressmax = $userAddressRepository->findBy(['User' => $this->getUser()]);

            //VERIF MAX 5 ADDRESS

            if(count($userAddressmax) >= 5){
                $this->addFlash('errors', 'You cannot add a new address because you are the maximum ( 5 address ) on your account');
                return $this->redirectToRoute('app_account');
            }

            $user = $user->findOneBy(['email' => $currentuser->getEmail()]);
            $userAddress->setUser($user);
            

            $this->em->persist($userAddress);
            $this->em->flush();
            $this->addFlash('success', 'You Add a New Address');
        }

        //GET USER POINTS
        $userPoints = $userFidelityPointsRepository->findOneBy(['User' => $this->getUser()]);
        $userPoints = $userPoints->getPoints();
        //GET USER ADDRESS
        $userAddress = $userAddressRepository->findBy(['User' => $this->getUser()]);
        

        return $this->render('account/index.html.twig', [
            'formPersonalDetails' => $formPersonalDetails->createView(),
            'formChangePassword' => $formChangePassword->createView(),
            'formAddAddress' => $formAddAddress->createView(),
            'userPoints' => $userPoints,
            'userAddress' => $userAddress,
        ]);
    }

    #[Route('/account/remove/{id}/address', name: 'app_account_remove_address')]
    public function removeaddress($id, UserAddressRepository $userAddressRepository): Response
    {
        $userAddress = $userAddressRepository->findOneBy(['id' => $id, 'User' => $this->getUser()]);

        if($userAddress){
            $this->addFlash('success', 'You Address is removed');
            $this->em->remove($userAddress);
            $this->em->flush();
            return $this->redirectToRoute('app_account');
        }else{
            $this->addFlash('errors', 'Address is not removed');
            return $this->redirectToRoute('app_account');
        }

    }
}
