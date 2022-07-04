<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('account/register.html.twig',
        );
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
        return $this->render('tricks/home.html.twig',
        );
    }
}
