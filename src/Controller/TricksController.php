<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentFormType;
use App\Form\TricksFormType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\MediaRepository;
use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use App\Services\TricksHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
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

        return $this->render('home.html.twig',  [
            'tricks' => $trickRepo->findAll()
        ]);
    }

    #[Route('/tricks/new', name: 'tricks_new')]
    public function new(Request $request, TricksHelper $helper): Response
    {
        $tricks = new Tricks();
        $form = $this->createForm(TricksFormType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tricks->initializeSlug();
            $helper->extracted($tricks, $form, $helper);
            $this->addFlash('success', 'Trick created');

            return $this->redirectToRoute('show', [
                'slug' => $tricks->getSlug(),
            ]);
        }

        return $this->render('tricks/new.html.twig',[
                'tricks_form' => $form->createView(),
            ]
        );
    }

    #[Route('/tricks/{slug}', name: 'show')]
    public function show($slug, Request $request, UserRepository $userRepo, CommentRepository $commentRepo, MediaRepository $mediaRepo, CategoryRepository $categoryRepo): Response
    {
        $tricks = $this->entityManager->getRepository(Tricks::class)->findCompleteTrick($slug);

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
                'id' => $tricks->getUser()]),
            'medias' => $mediaRepo->findBy([
                'tricks' => $tricks->getId()]),
            'category' => $categoryRepo->findBy([
                'id' => $tricks->getCategory()]),
            'comments' => $commentRepo->findBy([
                'tricks' => $tricks->getId()]),
            'comment_form' => $form->createView()
            ]
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/tricks/edit/{slug}', name: 'tricks_modify')]
    public function modify($slug, Request $request, TricksHelper $helper, TricksRepository $tricksRepo, MediaRepository $mediaRepo): Response
    {
        $tricks = $tricksRepo->findCompleteTrick($slug);
        $form = $this->createForm(TricksFormType::class, $tricks);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $helper->extracted($tricks, $form, $helper);

            $this->addFlash('success', 'Trick modified');

            return $this->redirectToRoute('show', [
                'slug' => $tricks->getSlug(),
            ]);
        }else{

            $this->addFlash('warning', 'One or more fields appear to be incorrect or missing');
        }
            return $this->render('tricks/modify.html.twig', [
                'tricks_form' => $form->createView(),
                'tricks' => $tricks,
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
