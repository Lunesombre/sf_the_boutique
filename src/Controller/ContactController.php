<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($request->request)
                ->to('contact@the_boutique.com')
                ->subject('test')
                ->text('test');


            $this->mailer->send($email);
        }



        return $this->renderForm('contact/form.html.twig', [
            'form' => $form,
        ]);
    }
}
