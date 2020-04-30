<?php

namespace App\Controller;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Picture :: class);
    }


    /**
     * @Route("/regarder", name="gallery")
     */
    public function index()
    {

        $pictures = $this->repository->findAll();

        return $this->render('gallery/index.html.twig', [
            'pictures' => $pictures,
        ]);
    }
}
