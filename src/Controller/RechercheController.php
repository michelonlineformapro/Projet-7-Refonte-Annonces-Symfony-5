<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche", name="recherche")
     */
    public function index(Request $request, AnnoncesRepository $annoncesRepository): Response
    {

        $prixMin = '';
        $prixMax = '';

        $message = [
            'message' => 'Test de debug'
        ];

        $searchForm = $this->createFormBuilder($message)
            ->add('prixMin', NumberType::class,[
                'label' => 'Prix minimum'
            ])
            ->add('prixMax', NumberType::class,[
                'label' => 'Prix maximum'
            ])
            ->add('rechercher', SubmitType::class,[
                'label' => 'Rechercher'
            ])
            ->getForm();

        $searchForm->handleRequest($request);

        if($request->isMethod('POST') && $searchForm->isSubmitted() && $searchForm->isValid()){
            $data = $searchForm->getData();
            //dd($data);
            $prixMin = $data['prixMin'];
            $prixMax = $data['prixMax'];
        }


        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'searchForm' => $searchForm->createView(),
            'resultSearchPrice' => $annoncesRepository->getMinMaxPrice($prixMin, $prixMax)
        ]);
    }
}
