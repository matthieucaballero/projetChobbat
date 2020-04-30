<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contacter", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $email = (new Email())
            ->from($contactFormData['from'])
            ->to('projetchobbat@gmail.com')
            ->subject('Un message de '.$contactFormData['name'].' depuis le site web')
            ->html( '<p>De '.$contactFormData['from'].'</p>'.
                    '<p>'.$contactFormData['message'].'</p>');

            $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
