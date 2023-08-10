<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\EmailType;
use Symfony\Component\HttpFoundation\Request;

use App\Form\EmailFormType; // Update the import
use Symfony\Component\HttpFoundation\RedirectResponse;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $mail = (new Email())
                ->from($data['from'])
                ->to($data['to'])
                ->subject($data['subject'])
                ->text($data['text']);

            try {
                $mailer->send($mail);
                $this->addFlash('success', 'Email sent successfully!');
            } catch (TransportExceptionInterface $error) {
                $this->addFlash('error', 'Error sending email: ' . $error->getMessage());
            }

            return $this->redirectToRoute('app_user_access'); // Redirect to the same route
        }

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
            'form' => $form->createView(),
        ]);
    }
}
