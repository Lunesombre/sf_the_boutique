<?php

namespace App\Controller;

use App\Contact\ContactNotifier;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form', methods: ['GET', 'POST'])]
    public function contact(Request $request, ContactNotifier $contactNotifier): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactNotifier->send($form->getData());

            $this->addFlash('success', 'Demande de contact envoyée.');

            return $this->redirectToRoute('app_index');
        }



        return $this->renderForm('contact/form.html.twig', [
            'form' => $form,
        ]);
    }
}
