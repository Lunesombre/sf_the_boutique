<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('contact@the_boutique.com')
                ->subject($contactFormData['objet'])
                ->text($contactFormData['message']);

            $mailer->send($email);

            $this->addFlash('success', 'Demande de contact envoyée.');

            return $this->redirectToRoute('app_index');
        }



        return $this->renderForm('contact/form.html.twig', [
            'form' => $form,
        ]);
    }
}
