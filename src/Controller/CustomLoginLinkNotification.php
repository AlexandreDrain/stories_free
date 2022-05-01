<?php

namespace App\Notifier;

use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkDetails;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

class CustomLoginLinkNotification extends LoginLinkNotification
{

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        $emailMessage = parent::asEmailMessage($recipient, $transport);

        $mail_expediteur = 'storieshare@example.com';
        // get the NotificationEmail object and override the template
        $email = $emailMessage->getMessage();
        $email->from($mail_expediteur);
        $email->htmlTemplate('security/login_link_sent.html.twig');

        return $emailMessage;
    }
}