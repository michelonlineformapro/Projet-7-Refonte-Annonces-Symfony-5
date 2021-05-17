<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    //Appel de la classe SwiftMailer en paramètre
    public function index(\Swift_Mailer $mailer): Response
    {
        $user = new User();

        $destinatiare = $user->getEmail();

        $email = [
            'email' => 'Debug email'
        ];





        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
