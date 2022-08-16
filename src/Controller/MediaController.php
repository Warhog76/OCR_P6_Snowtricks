<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/media/delete/{id}', name: 'media_delete')]
    public function delete($id, TricksRepository $tricksRepo, MediaRepository $mediaRepo): Response
    {
        $tricks = $tricksRepo->find($id);

        $medias = $mediaRepo->findOneby(['tricks' => $tricks->getId()]);
        $this->entityManager->remove($medias);

        $this->entityManager->flush();
        $this->addFlash('success', 'Media deleted');

        return $this->redirectToRoute('home');
    }

}