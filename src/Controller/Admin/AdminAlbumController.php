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
     * @Route("/admin/album", name="admin_album")
     */
    public function index()
    {
        $albums = $this->repository->findAll();
        
        return $this->render('admin/admin_album/index.html.twig', compact('albums'));
    }

    /**
     * @Route("/admin/album/create", name="admin_album_new")
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

    /**
     * @Route("/admin/album/{id}", name="admin_album_edit", methods="GET|POST")
     */
    public function edit(Request $request, Album $album )
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin_album');
        }

        return $this->render('admin/admin_album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/album/{id}", name="admin_album_delete", methods="DELETE")
     */
    public function delete(Album $album, Request $request)
    {

        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->get('_token'))) {
            $this->em->remove($album);
            $this->em->flush();    
        }

        return $this->redirectToRoute('admin_album');
    }





}
