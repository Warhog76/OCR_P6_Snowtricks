<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Tricks;
use App\Form\CommentFormType;
use App\Form\TricksFormType;
use App\Repository\CommentRepository;
use App\Repository\MediaRepository;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
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

            $this->denyAccessUnlessGranted('ROLE_USER');
            $user = $this->getUser();
            $tricks->setUser($user);

            $images = $form->get('media')->getData();

            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new media();
                $img->setName($fichier);
                $this->entityManager->persist($img);
                $tricks->addMedium($img);

            }

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
    public function show($id, Request $request, CommentRepository $commentRepo, MediaRepository $mediaRepo): Response
    {
        $repo = $this->entityManager->getRepository(Tricks::class);
        $tricks = $repo->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setTricks($tricks);

            $this->denyAccessUnlessGranted('ROLE_USER');
            $user = $this->getUser();
            $comment->setUser($user);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
        }
        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'medias' => $mediaRepo->findBy(
                ['tricks' => $tricks->getId()]),
            'comments' => $commentRepo->findBy(
                ['tricks' => $tricks->getId()]),
            'comment_form' => $form->createView()
            ]
        );
    }


    #[Route('/tricks/edit/{id}', name: 'tricks_modify')]
    public function modify($id): Response
    {
        $repoTricks = $this->entityManager->getRepository(Tricks::class);
        $repoMedia = $this->entityManager->getRepository(Media::class);
        $tricks = $repoTricks->find($id);
        $media = $repoMedia->find($id);

        return $this->render('tricks/modify.html.twig', [
                'tricks' => $tricks,
                'medias' => $media
            ]
        );
    }
}
