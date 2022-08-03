<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Form\TricksFormType;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    #[Route("", name: 'home')]
    public function home(TricksRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();

        return $this->render('home.html.twig',  [
            'tricks' => $tricks,
        ]);
    }

    #[Route('/tricks/new', name: 'tricks_new')]
    public function new(Request $request): Response
    {
        $tricks = new Tricks();
        $form = $this->createForm(TricksFormType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tricks->setCreatedAt(new \DateTimeImmutable());

            $session = $this->requestStack->getSession();
            $user = $session->get('username');
            $tricks->setUser($user);

            $this->entityManager->persist($tricks);
            $this->entityManager->flush();

            return $this->redirectToRoute('show', [
                'id' => $tricks->getId(),
            ]);
        }

        return $this->render('tricks/new.html.twig',[
                'tricks_form' => $form->createView(),
            ]
        );
    }

    #[Route('/tricks/{id}', name: 'show')]
    public function show($id): Response
    {
        $repo = $this->entityManager->getRepository(Tricks::class);
        $tricks = $repo->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
        }
        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'comment_form' => $form->createView()
            ]
        );
    }


    #[Route('/tricks/edit/{id}', name: 'tricks_modify')]
    public function modify($id): Response
    {
        $repo = $this->entityManager->getRepository(Tricks::class);
        $tricks = $repo->find($id);

        return $this->render('tricks/modify.html.twig', [
                'tricks' => $tricks
            ]
        );
    }
}
