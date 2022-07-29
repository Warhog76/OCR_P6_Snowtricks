<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AccountFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AccountController extends AbstractController
{
    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/register', name: 'register')]
    public function register(Request $request): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountFormType::class, $account);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData() ;

            $this->entityManager->persist($account);
            $this->entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('account/login.html.twig',
        );
    }

    #[Route('/account/reset', name: 'reset')]
    public function resetPassword(): Response
    {
        return $this->render('account/reset.html.twig',
        );
    }

    #[Route('/account/forgot', name: 'forgot')]
    public function forgotPassword(): Response
    {
        return $this->render('account/forgot.html.twig',
        );
    }

    #[Route('/account/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('account/profile.html.twig',
        );
    }

    #[Route('/account/editProfile', name: 'editProfile')]
    public function editProfile(): Response
    {
        return $this->render('account/editProfile.html.twig',
        );
    }

    #[Route('/account/logout', name: 'logout')]
    public function logout(): Response
    {
        return $this->render('home.html.twig',
        );
    }
}
