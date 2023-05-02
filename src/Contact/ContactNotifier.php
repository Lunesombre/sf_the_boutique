<?php

namespace App\Contact;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class ContactNotifier
// nb rien à voir avec le composant Notifier de Symfony
{
    public function __construct(
        private MailerInterface $mailer,
        private string $contactEmail
    ) {
    }

    public function send(array $data) : void
    {
        $email = (new Email())
            ->from($data['email'])
            ->to($this->contactEmail)
            ->subject('Nouvelle demande : ' . $data['objet'])
            ->text($data['message']);

        $this->mailer->send($email);
    }
}
