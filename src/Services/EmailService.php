<?php


namespace App\Services;


use App\Entity\Annonces;
use Swift_Image;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class EmailService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * EmailService constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     */

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    //Le service d'envoi email

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function sendMailToAdmin(Annonces $annonces, $visiteur, $sujet, $message){
        $emailMessage = new Swift_Message();

        //$getImages = $annonces->getImageAnnonces();
        $img = $emailMessage->embed(Swift_Image::fromPath('img/bic.jpg'));

        $emailMessage
            ->setFrom('admin@admin.fr', 'michael')
            ->setTo('test@test.fr', 'michael')
            ->setBody(
                $this->twig->render('mail/email.html.twig',[
                    'visiteur' => $visiteur,
                    'sujet' => $sujet,
                    'message' => $message,
                    'img' =>$img,
                    'annonce' => $annonces
                ]),
                'text/html'
            );

        $this->mailer->send($emailMessage);

    }
}