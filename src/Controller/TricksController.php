<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksFormType;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/tricks', name: 'app_tricks')]
    public function index(): Response
    {
        return $this->render('tricks/index.html.twig', [
            'controller_name' => 'TricksController',
        ]);
    }

    #[Route("", name: 'home')]
    public function home(TricksRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();

        return $this->render('home.html.twig',  [
            'tricks' => $tricks,
        ]);
    }

    #[Route('/tricks/{id}', name: 'show')]
    public function show($id): Response
    {
        $repo = $this->entityManager->getRepository(Tricks::class);
        $tricks = $repo->find($id);

        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks
            ]
        );
    }

    #[Route('/tricks/new', name: 'tricks_new')]
    public function new(Request $request): Response
    {
        $tricks = new Tricks();
        $form = $this->createForm(TricksFormType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tricks->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($tricks);
            $this->entityManager->flush();

            return $this->redirectToRoute('show', ['id' => $tricks->getId()]);
        }

        return $this->render('tricks/new.html.twig',[
                'tricks_form' => $form->createView(),
            ]
        );
    }

    #[Route('/tricks/modify', name: 'tricks_modify')]
    public function modify(): Response
    {
        return $this->render('tricks/modify.html.twig',
        );
    }
}
