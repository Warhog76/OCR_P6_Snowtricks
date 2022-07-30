<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /*#[Route('/user/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig',
        );
    }*/

    /*#[Route('/user/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig',
        );
    }*/

    #[Route('/user/reset', name: 'reset')]
    public function resetPassword(): Response
    {
        return $this->render('user/reset.html.twig',
        );
    }

    #[Route('/user/forgot', name: 'forgot')]
    public function forgotPassword(): Response
    {
        return $this->render('user/forgot.html.twig',
        );
    }

    #[Route('/user/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig',
        );
    }

    #[Route('/user/editProfile', name: 'editProfile')]
    public function editProfile(): Response
    {
        return $this->render('user/editProfile.html.twig',
        );
    }

    #[Route('/user/logout', name: 'logout')]
    public function logout(): Response
    {
        return $this->render('home.html.twig',
        );
    }
}
