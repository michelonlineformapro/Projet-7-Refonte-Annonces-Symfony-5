<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\RechercheType;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccueilController
 * @package App\Controller
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_annonces")
     * Ici le 1er element est url dans votre navigateur
     * le name est utilisé pour creer des liens <a href>
     * Rappel pour lister vos route php bin/console debug:router
     */
    public function index(AnnoncesRepository $annoncesRepository, Request $request): Response
    {
        //Dans cette methode on appel le patron de conception Annonce Repository creer lors de la generartion de l'entité annonce
        //Cette classe permet d'acceder au 4 methodes de base find, findOneBy, findAll et findBy

        //Render appel de manière abstraite Response puis un fichier Twig pour afficher une vue



        $annonces = new Annonces();
        $searchForm = $this->createForm(RechercheType::class, $annonces);
        $searchForm->handleRequest($request);

        $prix = $annonces->getPrixAnnonces();
        $cat =$annonces->getCategories();
        $region = $annonces->getRegions();


        return $this->render('accueil/accueil.html.twig', [
            //Dans ce tableau associatif la cle lister_annonce sera utilisée dans twig (dans une boucle for) pour lister les annonces
            //Cette clé est egale a l'entité annonce avec un parcours de tous ses elements grace a la methode findAll de annonceRepository
            'searchForm' => $searchForm->createView(),
            'lister_annonces' => $annoncesRepository->searchParameters($prix,$cat,$region)
        ]);
    }

    /**
     * @Route ("/accueil/{slug}/{id}", name="accueil_annonces_id")
     * Ici on passe dans url le nom de l'annonce (slug) et son id
     * https://github.com/cocur/slugify
     */

    public function annonceParId(Annonces $annonces):Response{
        //Dans cette methode l'entité annonce est passée en paramètre pour acceder aux Getters et Setters

        //Appel de la vue concernée


        return  $this->render('accueil/details.html.twig',[

            //Dans ce tableau associatif la clé annonce accèse a l'entité

            //Cette cle sera utilisée dans votre vue Twig pour afficher les elements de l'entitié

            //ex: {{ annonces.nomAnnonce }} ici nomAnnonce() est un getter de l'entité annonce

            "annonces" => $annonces
        ]);
    }

}

