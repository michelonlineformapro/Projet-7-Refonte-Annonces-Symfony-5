<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
        //Initialisation des variables (champs du formulaire)

        $prixMin = '';
        $prixMax = '';
        //Mot cle -> nom des annonces
        $mot = '';

        $message = [
            'message' => 'Test de debug'
        ];

        //Creation du formulaire directement dans un controller avec createFormBuilder
        $searchForm = $this->createFormBuilder($message)
            //Le prix min + champs non obligatoire
            ->add('prixMin', NumberType::class,[
                'label' => 'Prix minimum',
                'required' => false
            ])
            ->add('prixMax', NumberType::class,[
                'label' => 'Prix maximum',
                'required' => false
            ])
                //Ce champ est de type searchType extenssion (lors de la creation d'un formulaire en ligne de commande php bin/console make:form
                //Ne pas appeler le formulaire SearchType sous peine de conflit
            ->add('mot', SearchType::class,[
                'label' => 'Recherche par mot cle',
                'attr' => [
                    'placeholder' => 'Chaise'
                ],
                'required' => false
            ])
            ->add('rechercher', SubmitType::class,[
                'label' => 'Rechercher'
            ])
            //Ici on utilise la methode getForm() pour finaliser la creation du formulaire
            ->getForm();
        //Recupération des donnée du champs (<input name=""> soit form[prixMin] form[prixMax] et form[mot] (f12 dans le navigateur))
        $searchForm->handleRequest($request);

        //A la soumission du formulaire
        if($request->isMethod('POST') && $searchForm->isSubmitted() && $searchForm->isValid()){
            $data = $searchForm->getData();
            //dd($data);
            $prixMin = $data['prixMin'];
            $prixMax = $data['prixMax'];
            $mot = $data['mot'];
            //dd($mot);
        }

        //Retourne la vue + le formulaire + l'appel de la methode custom du repository et ses paramètres
        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'searchForm' => $searchForm->createView(),
            'resultSearchPrice' => $annoncesRepository->getMinMaxPrice($prixMin, $prixMax,$mot)
        ]);
    }
}
