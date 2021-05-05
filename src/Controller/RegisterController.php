<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        //1 - Contruire le formulaire
        //Instance de entity user
        $user = new User();

        //Creer le formulaire
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        //Soumission du formulaire
        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()){

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            //Persiter les données
            $entityManager->persist($user);
            //Enregister le valeur du formumaire
            $entityManager->flush();

            //Si ca marche
            return $this->redirectToRoute('app_login');

        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'user' => $user,
            'registerForm' => $form->createView()
        ]);
    }
}
