<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\RechercheType;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

        //Instance de entité annonce
        $annonces = new Annonces();
        //Formulaire de recherche -> creation du formulaire avec en paramètres (form/RechercherType + instance de entité annonce)
        $searchForm = $this->createForm(RechercheType::class, $annonces);
        //Recupe des valuers des champs du formulaire
        $searchForm->handleRequest($request);

        //Appel des GETTERS
        //Recup du prix de l'annonces
        $prix = $annonces->getPrixAnnonces();
        //Recup de la categorie de l'annonce
        $cat =$annonces->getCategories();
        //Recup de la regions de l'annonce
        $region = $annonces->getRegions();

        //Appel de la vue
        return $this->render('accueil/accueil.html.twig', [
            //Dans ce tableau associatif la cle lister_annonce sera utilisée dans twig (dans une boucle for) pour lister les annonces
            //Cette clé est egale a l'entité annonce avec un parcours de tous ses elements grace a la methode searchParameter de annonceRepository
            'searchForm' => $searchForm->createView(),
            //Appel de la methode creer dans annonce repository + ses paramètres
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

    /**
     * Cette methode est appelée sur le bouton ajouter au panier de la vue accueil/accueil.html.twig
     * @Route("/ajouter_panier/{id}", name="ajouter_panier")
     */

    public function ajouterPanier(SessionInterface $session, Annonces $annonces){
        //Récupération de la session et de sont tableau de valeur
        $panier = $session->get("panier", []);
        //Recupération de chaque id des annonces
        $id = $annonces->getId();

        //Condition = lors du click si le panier est vide on incremente
        if(!empty($panier[$id])){
            $panier[$id]++;
            //Sinon la quantité est egale a 1
        }else{
            $panier[$id] = 1;
        }

        //On ajoute les valeur de $panier à la session

        $session->set("panier", $panier);
        //Appel de la route voir_apnier = /voir-panier qui appel la vue panier.html.twig
        return $this->redirectToRoute('voir_panier');
    }


    /**
     * @Route("/enlever_panier/{id}", name="enlever_panier")
     */

    public function enleverPanier(SessionInterface $session, Annonces $annonces){

        //Recupération des variables de session cle + valeur tableau panier
        $panier = $session->get("panier", []);
        //Recupération de l'id de chaque annonces
        $id = $annonces->getId();

        //Si le tableau n'est vide et que la quantité est > à 1
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                //On decermente
                $panier[$id]--;
            }else{
                //Si la quantité est < à 1 on retire la ligne entière
                unset($panier[$id]);
            }
        }

        //On ajoute les valeur de $panier à la session
        $session->set("panier", $panier);
        //On redirige vers la route voir_panier qui appel la vue panier.html.twig
        return $this->redirectToRoute('voir_panier');
    }


    /**
     * @Route("/voir-panier", name="voir_panier")
     */

    public function voirPanier(SessionInterface $session, AnnoncesRepository $annoncesRepository){
        //Recup des valeurs de session du tableau panier
        $panier = $session->get("panier", []);
        //Creation d'un tableau de recap des valeurs de sessions
        $dataPanier = [];
        //Init du prix total quantité * prix
        $total = 0;

        //Boucle de parcours des valeurs du panier par id + quantité
        foreach ($panier as $id => $quantite){
            //Recup des annonces par id
            $annonce = $annoncesRepository->find($id);
            //en fonction de id on recup l'annonce + la quantité
            $dataPanier[] = [
                "annonce" => $annonce,
                "quantite" => $quantite
            ];

            //Calcul du total de toutes les annonces mis au panier
            $total += $annonce->getPrixAnnonces() * $quantite;
        }

        //Appel de la vue recap du panier + tableau de valeur + total utlisable dans Twig {{ dataPanier.annonce + dataPanier.quantite et total}}
        return $this->render('accueil/panier.html.twig',[
            "dataPanier" => $dataPanier,
            "total" => $total
        ]);
    }

}

