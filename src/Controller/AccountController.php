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

    #[Route('/account/resetPass', name: 'resetPass')]
    public function resetPassword(): Response
    {
        return $this->render('account/reset.html.twig',
        );
    }

    #[Route('/account/newPass', name: 'newPass')]
    public function newPassword(): Response
    {
        return $this->render('account/register.html.twig',
        );
    }
}
