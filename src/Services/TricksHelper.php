<?php

namespace App\Services;

use App\Entity\Media;
use App\Entity\Tricks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TricksHelper extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function renamePath(UploadedFile $image): string
    {
        return md5(uniqid()).'.'.$image->guessExtension();
    }

    public function imageUpload(Tricks $tricks, array $images): void
    {
        foreach ($images as $image) {
            $fileName = $this->renamePath($image);
            $image->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $img = new Media();
            $img->setName($fileName);
            $img->setType('image');

            $this->entityManager->persist($img);
            $tricks->addMedium($img);
        }
    }

    public function videoValidator(string $value): string
    {
        $pattern = "/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/";

        preg_match($pattern, $value, $matches);

        if (empty($matches[5])) {
            throw $this->createNotFoundException('l\'url n\'est pas bonne !');
        }
        return $matches[5];
    }

    public function videoUpload(Tricks $tricks, $video): void
    {
        $vidUrl = new Media();
        $vidUrl->setName('https://www.youtube.com/embed/' .$this->videoValidator($video));
        $vidUrl->setType('video');

        $this->entityManager->persist($vidUrl);
        $tricks->addMedium($vidUrl);
    }

    /**
     * @param Tricks|null $tricks
     * @param FormInterface $form
     * @param TricksHelper $helper
     * @return void
     */
    public function extracted(?Tricks $tricks, FormInterface $form, TricksHelper $helper): void
    {
        $tricks->setCreatedAt(new \DateTimeImmutable());

        $user = $this->getUser();
        $tricks->setUser($user);

        $images = $form->get('images')->getData();
        if ($images != null) {
            $helper->imageUpload($tricks, $images);
        }

        $video = $form->get('videos')->getData();
        if ($video != null) {
            $helper->videoUpload($tricks, $video);
        }

        $this->entityManager->persist($tricks);
        $this->entityManager->flush();
    }
}
