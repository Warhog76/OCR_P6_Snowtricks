<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksFormTyprType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    #[Route('/tricks', name: 'app_tricks')]
    public function index(): Response
    {
        return $this->render('tricks/index.html.twig', [
            'controller_name' => 'TricksController',
        ]);
    }

    #[Route("", name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig'
        );
    }

    #[Route('/tricks/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('tricks/show.html.twig',
        );
    }

    #[Route('/tricks/new', name: 'tricks_new')]
    public function new(): Response
    {
        return $this->render('tricks/new.html.twig',
        );
    }

    #[Route('/tricks/modify', name: 'tricks_modify')]
    public function modify(): Response
    {
        return $this->render('tricks/modify.html.twig',
        );
    }
}
