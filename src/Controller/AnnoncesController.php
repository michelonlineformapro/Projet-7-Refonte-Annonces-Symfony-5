<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\User;
use App\Form\AnnoncesType;
use App\Form\RechercheType;
use App\Repository\AnnoncesRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AnnoncesController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 * @Route("/utilisateurs")
 */

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces")
     * Ici le 1er element est url dans votre navigateur
     * le name est utilisé pour creer des liens <a href>
     * Rappel pour lister vos route php bin/console debug:router
     */
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        //Dans cette methode on appel le patron de conception Annonce Repository creer lors de la generartion de l'entité annonce
        //Cette classe permet d'acceder au 4 methodes de base find, findOneBy, findAll et findBy

        //Render appel de manière abstraite Response puis un fichier Twig pour afficher une vue

        return $this->render('annonces/index.html.twig', [
            //Dans ce tableau associatif la cle lister_annonce sera utilisée dans twig (dans une boucle for) pour lister les annonces
            //Cette clé est egale a l'entité annonce avec un parcours de tous ses elements grace a la methode findAll de annonceRepository
            //On affiche toutes les données en fonction de la cle etrangère utilisateur_id de l'entité annonce grace a twig
            //{{ app.user.annonces }} => fait reference à $private annonces dans l'entité User qui est mappée sur l'entité annonce $utilisateur inversedBy = annonces(Dans User)
            //'test' => $annoncesRepository->findAll()

        ]);

    }

    /**
     * @Route ("/{slug}/{id}", name="annonces_id")
     * Ici on passe dans url le nom de l'annonce (slug) et son id
     * https://github.com/cocur/slugify
     */

    public function annonceParId(Annonces $annonces, $id, AnnoncesRepository $annoncesRepository):Response{
        //Dans cette methode l'entité annonce est passée en paramètre pour acceder aux Getters et Setters

        $detail = $annoncesRepository->find($id);
        //Appel de la vue concernée


        return  $this->render('annonces/details.html.twig',[

            //Dans ce tableau associatif la clé annonce accèse a l'entité

            //Cette cle sera utilisée dans votre vue Twig pour afficher les elements de l'entitié

            //ex: {{ annonces.nomAnnonce }} ici nomAnnonce() est un getter de l'entité annonce

            "annonces" => $detail
        ]);
    }

    /**
     * @Route("/ajouter", name="annonces_ajouter")
     * @IsGranted ("ROLE_USER")
     */

    public function ajouterAnnonce(Request $request):Response{

        //Instance de l'entité annonces
        $annonces = new Annonces();
        //Ici on recupere id de l'utilisateur
        $annonces->setUtilisateurs($this->getUser());

        //Creer le formulaire = le methode createForm prend 2 paramètres
        //Le nom de la classe du form builder concerné (php bin/console make:form)
        //AnnonceType spécifie la creation et les paramètres du formulaire
        //En second paramètre : on accède a l'entité annonce et Getters et Setters

        $formAnnonces = $this->createForm(AnnoncesType::class, $annonces);

        //Creer le bouton soumission
        $formAnnonces
            ->add('btn_ajouter', SubmitType::class,[
            'label' => 'Ajouter annonces',
        ]);


        //Recuper les champs (valeur) du formulaire entré par l'utilisateur
        $formAnnonces->handleRequest($request);

        //Si le formulaire utilise la methode post et tous les champs sont rempli

        if($request->isMethod("POST") && $formAnnonces->isSubmitted() && $formAnnonces->isValid()){

            //Recupreation de la propriété privée de l'image dans l'entité
            $file = $formAnnonces["imageAnnonces"]->getData();

            //Si la valueur du champ n'est pas de type chaine de caractère

            if(!is_string($file)){

                //On recupère le nom du ficier uploader

                $fileName = $file->getClientOriginalName();

                //deplacement de la photo = move_uploaded_file($_FILES['userfile']['tmp_name'] en php
                $file->move(
                    //Destination du fichier configurer dans le dossier config/services.yaml => parameters
                    //images_directory: '%kernel.project_dir%/public/img'
                    //En second paramètre = le nom du fichier
                    $this->getParameter("images_directory"),
                    $fileName
                );
                //Attribution de la photo a l'entité a l'aide des setters
                $annonces->setImageAnnonces($fileName);

                $this->addFlash('success', 'Votre annonce à bien été ajouté !');
            }else{

                $this->addFlash('danger', 'Une erreur est survenur durant la création de votre annonce !');
                return $this->redirect($this->generateUrl('annonces_ajouter'));
            }


            //Si le formuaire est valide = on accède au manager a l'aide de doctrine
            $entityManager = $this->getDoctrine()->getManager();
            //On signale au manager qu'il doit persister le donnée dans l'entité Annonce
            $entityManager->persist($annonces);
            //On valide l'enregistrement des valeurs du formulaire dans l'entité
            $entityManager->flush();
            //Si tous fonctionne on redirige l'utilisateur vers la page des annonces
            return $this->redirectToRoute('annonces');

        }

        //Afficher le formulaire dans la vue ajouter.html.twig
        return $this->render('annonces/ajouter.html.twig',[
            //Dans ce tableau associatif la cle = form_ajouter_annonce permet d'acceder et d'afficher le formulaire avex twig
            //{{ form(form_ajouter_annonce) }}
            'form_ajouter_annonce' => $formAnnonces->createView()
        ]);

    }

    /**
     * @Route ("/annonces/editer/{id}", name="editer_annonce")
     */


    public function editerAnnonce(Request $request, $id):Response{
        //Entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        //Appel du repository pour acceder au 4 methodes de base find() findOneBy(), findBy(), findAll()
        $annonceRepository = $entityManager->getRepository(Annonces::class);

        $annonce = $annonceRepository->find($id);

        //Recup de l'image
        $img = $annonce->getImageAnnonces();

        //Creation du formulaire
        //Enparamètre on passe Le AnnonceType et en 2nd l'entité
        $formEditAnnonce = $this->createForm(AnnoncesType::class, $annonce);
        //Creation du bouton de soumisiion
        $formEditAnnonce->add('editer', SubmitType::class,[
            'label' => 'Mettre le l\'annonce'
        ]);
        //Recuperation des champs (input) du formulaire d'edition
        $formEditAnnonce->handleRequest($request);
        //Verifier la methode (post) du formilaire ey que les champs ne sont pas vide
        if($request->isMethod('POST') && $formEditAnnonce->isSubmitted() && $formEditAnnonce->isValid()){
            //Traitrement du fichier upload
            $file = $formEditAnnonce['imageAnnonces']->getData();

            if(!is_string($file)){
                $fileName = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $annonce->setImageAnnonces($fileName);
                $this->addFlash('success', 'Votre photo à bien modifiée !');
            }else{
                $annonce->setImageAnnonces($img);
            }
            $entityManager->persist($annonce);
            //Valider les nouvelles valeur de l'annonce
            $entityManager->flush();
            $this->addFlash('success', 'Votre annonce à bien modifiée !');
            return $this->redirectToRoute('annonces');
        }
        return $this->render('annonces/editer.html.twig',[
            'form_edit_annonce' => $formEditAnnonce->createView()
        ]);

    }

    //Dans cette methode on passe id dans url (ici pas besoin de vue)


    /**
     * @Route ("/supprimer/{id}", name="annonces_supprimer")
     */
    public function supprimerAnnonce(Request $request, $id):Response{

        //On passe un $id en paramètre de la methode et on appel la classe Request
        //Appel de doctrine et de entity manager

        $entityManager = $this->getDoctrine()->getManager();

        //Recupreation du repository Annonces avec l'entité annonces en paramètre
        $annonceRepository = $entityManager->getRepository(Annonces::class);
        //Appel de la methode find qui ne retourne qu'un seul résultat (ici id passé en paramètre de la methode)
        $annonces = $annonceRepository->find($id);
        //Supression de l'annonce a l'aide de la methode remove (annonce->getId())
        $entityManager->remove($annonces);
        //Confirmer et enrigistrer la supression
        $entityManager->flush();

        //Après la supression on redirige l'utilisateur vers la page des annonces
        return $this->redirect($this->generateUrl('annonces'));

    }

}
