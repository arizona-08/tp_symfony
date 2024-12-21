<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class TestEmailController extends AbstractController
{
    #[Route('/test-email', name: 'test_email')]
    public function sendTestEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('test@example.com')
            ->to('recipient@example.com') // Use a test email
            ->subject('Test Email')
            ->text('This is a test email.');

        try {
            $mailer->send($email);
            return $this->json(['status' => 'Email sent successfully']);
        } catch (\Exception $e) {
            return $this->json(['status' => 'Failed to send email', 'error' => $e->getMessage()]);
        }
    }
}