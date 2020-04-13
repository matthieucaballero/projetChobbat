<?php

namespace App\Controller\Admin;

use App\Entity\Track;
use App\Form\TrackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminTrackController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Track :: class);
    }


    /**
     * @Route("/admin/track", name="admin_track")
     */
    public function index()
    {
        $tracks = $this->repository->findAll();
        
        return $this->render('admin/admin_track/index.html.twig', compact('tracks'));
    }

    /**
     * @Route("/admin/track/create", name="admin_track_new")
     */
    public function new(Request $request)
    {
        
        $track = new Track(); 

        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($track);
            $this->em->flush();
            return $this->redirectToRoute('admin_track');
        }

        return $this->render('admin/admin_track/new.html.twig', [
            'track' => $track,
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/track/{id}", name="admin_track_edit", methods="GET|POST")
     */
    public function edit(Request $request, Track $track )
    {
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin_track');
        }

        return $this->render('admin/admin_track/edit.html.twig', [
            'track' => $track,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/track/{id}", name="admin_track_delete", methods="DELETE")
     */
    public function delete(Track $track, Request $request)
    {

        if ($this->isCsrfTokenValid('delete'.$track->getId(), $request->get('_token'))) {
            $this->em->remove($track);
            $this->em->flush();    
        }

        return $this->redirectToRoute('admin_track');
    }










}
