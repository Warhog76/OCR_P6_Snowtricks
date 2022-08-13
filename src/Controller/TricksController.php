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
use App\Repository\UserRepository;
use App\Services\TricksHelper;
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
    public function home(TricksRepository $trickRepo): Response
    {
        $tricks = $trickRepo->findAll();

        return $this->render('home.html.twig',  [
            'tricks' => $tricks
        ]);
    }

    #[Route('/tricks/new', name: 'tricks_new')]
    public function new(Request $request, TricksHelper $helper): Response
    {
        $tricks = new Tricks();
        $form = $this->createForm(TricksFormType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tricks->setCreatedAt(new \DateTimeImmutable());

            $user = $this->getUser();
            $tricks->setUser($user);

            $images = $form->get('images')->getData();
            $helper->imageUpload($tricks, $images);

            $video = $form->get('videos')->getData();
            $helper->videoUpload($tricks,$video);

            $this->entityManager->persist($tricks);
            $this->entityManager->flush();
            $this->addFlash('success', 'Trick created');

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
    public function show($id, Request $request, UserRepository $userRepo, CommentRepository $commentRepo, MediaRepository $mediaRepo): Response
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
            'user' => $userRepo->find([
                'id' => $tricks->getuser()]),
            'medias' => $mediaRepo->findby([
                'tricks' => $tricks->getId()]),
            'comments' => $commentRepo->findBy([
                'tricks' => $tricks->getId()]),
            'comment_form' => $form->createView()
            ]
        );
    }

    #[Route('/tricks/edit/{id}', name: 'tricks_modify')]
    public function modify($id,Request $request, Tricks $tricks, MediaRepository $mediaRepo): Response
    {

        $form = $this->createForm(TricksFormType::class, $tricks);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tricks=$form->getData();

            $this->entityManager->persist($tricks);
            $this->entityManager->flush();

            $this->addFlash('success', 'Trick modified');

            return $this->redirectToRoute('show', [
                'id' => $tricks->getId(),
            ]);
        }
            return $this->render('tricks/modify.html.twig', [
                'tricks' => $tricks,
                'form' => $form,
                'medias' => $mediaRepo->findby([
                    'tricks' => $tricks->getId()]),
            ]);
    }

    #[Route('/tricks/delete/{id}', name: 'tricks_delete')]
    public function delete($id, TricksRepository $tricksRepo, MediaRepository $mediaRepo, CommentRepository $commentRepo): Response
    {
        $tricks = $tricksRepo->find($id);

        $medias = $mediaRepo->findby(['tricks' => $tricks->getId()]);
        foreach ($medias as $media){
            $this->entityManager->remove($media);
        }

        $comments = $commentRepo->findby(['tricks' => $tricks->getId()]);
        foreach ($comments as $comment){
            $this->entityManager->remove($comment);
        }

        $this->entityManager->remove($tricks);
        $this->entityManager->flush();
        $this->addFlash('success', 'Trick deleted');

        return $this->redirectToRoute('home');
    }
}
