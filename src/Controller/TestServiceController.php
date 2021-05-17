<?php

namespace App\Controller;

use App\Services\TestServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestServiceController extends AbstractController
{
    /**
     * @Route("/test/service", name="test_service")
     */


    //Appel du service src/Service grace a l'inhection de dépédance
    public function index(TestServices $testServices): Response
    {

        //Appel de la classe (src/Services ) et accès au methodes
        $messages = $testServices->getRandomMessage();

        //Creation des flashBag
        $this->addFlash('success', $messages);

        return $this->render('test_service/index.html.twig', [
            'controller_name' => 'TestServiceController',
        ]);
    }
}
