<?php

namespace App\Controller;

use App\Entity\Album;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListenController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Album :: class);
    }


    /**
     * @Route("/ecouter", name="listen")
     */
    public function index()
    {
        $albums = $this->repository->findAll();

        return $this->render('listen/index.html.twig', compact('albums'));
    }
}
