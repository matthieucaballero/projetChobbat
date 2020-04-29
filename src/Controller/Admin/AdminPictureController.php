<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPictureController extends AbstractController
{
    /**
     * @Route("/admin/picture", name="admin_picture")
     */
    public function index()
    {
        return $this->render('admin/admin_picture/index.html.twig', [
            'controller_name' => 'AdminPictureController',
        ]);
    }
}
