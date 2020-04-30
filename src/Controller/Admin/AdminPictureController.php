<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Form\PictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPictureController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Picture :: class);
    } 


    /**
     * @Route("/admin/picture", name="admin_picture")
     */
    public function index()
    {
        $pictures = $this->repository->findAll();
        
        return $this->render('admin/admin_picture/index.html.twig', compact('pictures'));
    
    }


    /**
     * @Route("/admin/picture/create", name="admin_picture_new")
     */
    public function new(Request $request)
    {
        
        $picture = new Picture(); 

        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($picture);
            $this->em->flush();
            return $this->redirectToRoute('admin_picture');
        }

        return $this->render('admin/admin_picture/new.html.twig', [
            'picture' => $picture,
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/picture/{id}", name="admin_picture_edit", methods="GET|POST")
     */
    public function edit(Request $request, Picture $picture )
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin_picture');
        }

        return $this->render('admin/admin_picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/picture/{id}", name="admin_picture_delete", methods="DELETE")
     */
    public function delete(Picture $picture, Request $request)
    {

        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->get('_token'))) {
            $this->em->remove($picture);
            $this->em->flush();    
        }

        return $this->redirectToRoute('admin_picture');
    }











}
