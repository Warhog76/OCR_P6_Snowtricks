<?php

namespace App\Controller;

use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Services\TricksHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/profile', name: 'profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/user/editProfile', name: 'editProfile')]
    public function editProfile(Request $request, UserRepository $userRepo, TricksHelper $helper): Response
    {
        $user = $userRepo->find([
            'id' => $this->getUser()]);
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Profile modified');

            return $this->redirectToRoute('profile', [
                'user' => $user
            ]);
        }

        return $this->render(
            'user/editProfile.html.twig',
            [
                'user_form' =>$form->createView(),
                'user' => $user
            ]
        );
    }

    #[Route('/user/logout', name: 'logout')]
    public function logout(): Response
    {
        return $this->render(
            'home.html.twig',
        );
    }
}
