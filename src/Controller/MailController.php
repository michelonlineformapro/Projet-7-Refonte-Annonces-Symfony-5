<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\User;
use App\Services\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/{id}", name="mail")
     */
    //Appel de la classe SwiftMailer en paramètre
    public function sendEmail(Request $request, Annonces $annonces, EmailService $emailService): Response
    {

        $debug = [
            'test' => 'Debug email'
        ];

        //Creation d'un fomulaire contact
        $emailForm = $this->createFormBuilder($debug)
            ->add('email', TextType::class,[
                'label' => 'Votre email'
            ])
            ->add('sujet', TextType::class,[
                'label' => 'Sujet de l\'email'
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Votre message'
            ])
            ->add('envoyer', SubmitType::class,[
                'label' => 'Envoyer email'
            ])
            ->getForm();

        //Recuperer les valeurs des champs du formulmaire
        $emailForm->handleRequest($request);

        //Les condition de validation
        if($request->isMethod('POST') && $emailForm->isSubmitted() && $emailForm->isValid()){
            $emailDatas = $emailForm->getData();
            //dd($emailDatas);
            $visiteur = $emailDatas['email'];
            $sujet = $emailDatas['sujet'];
            $message = $emailDatas['message'];
            //$img = $annonces->getImageAnnonces();

            $this->addFlash('success', 'Votre a bien été envoyé, une réponse va rapidement vous etre envoyé !');
            //Appel du sevice email

            $emailService->sendMailToAdmin($annonces, $visiteur, $sujet, $message);

        }

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
            'emailForm' => $emailForm->createView()
        ]);
    }
}
