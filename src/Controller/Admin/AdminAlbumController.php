<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminAlbumController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Album :: class);
    }






    /**
     * @Route("/admin/albums", name="admin_album")
     */
    public function index()
    {
        return $this->render('admin/admin_album/index.html.twig', [
            'controller_name' => 'AdminAlbumController',
        ]);
    }

    /**
     * @Route("/admin/albums/create", name="admin_album_new")
     */
    public function new(Request $request)
    {
        
        $album = new Album(); 

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($album);
            $this->em->flush();
            return $this->redirectToRoute('admin_album');
        }

        return $this->render('admin/admin_album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView()
        ]);
        
    }


}
