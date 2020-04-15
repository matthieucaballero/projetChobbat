<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListenController extends AbstractController
{
    /**
     * @Route("/ecouter", name="listen")
     */
    public function index()
    {
        return $this->render('listen/index.html.twig', [
            'controller_name' => 'ListenController',
        ]);
    }
}
