<?php

namespace App\Services;

use App\Entity\Media;
use App\Entity\Tricks;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class TricksHelper extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function renamePath(UploadedFile $image): string
    {
        return md5(uniqid()).'.'.$image->guessExtension();
    }

    public function imageUpload(Tricks $tricks, array $images): void
    {
        foreach ($images as $image)
        {
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

            if (empty($matches[5]))
            {
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

}