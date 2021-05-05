<?php

namespace App\Repository;

use App\Entity\Annonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonces|null find($id, $lockMode = null, $lockVersion = null) // retourne l'entité en fonction de son id
 * @method Annonces|null findOneBy(array $criteria, array $orderBy = null) //comme findBy mais ne retourne qu'une seule entité
 * @method Annonces[]    findAll()// retourne tous les element d'une entité
 * @method Annonces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) // retourne plusieur entité en fonction de la valeur d'une propriété (ex: stock = true)
 */

//count(array('stock' => true) retourne le nombre d'element trouvé ici tous les produit en stock
class AnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonces::class);
    }

    // /**
    //  * @return Annonces[] Returns an array of Annonces objects
    //  */

    /*
     * EN DQL
     * methode getResult() = ensemble des resultats de la requète
     * getSingleResult() = retourne un seul objet : si la requete retourne plusieur objet ou aucun une erreur apparait
     * getOneOrNullObject() = retourne un seul objet : si la requete retourne plusieur objet  une erreur apparait si aucun ca retourne null
     * getScalarResult = retourne des valeurs scalaire pouvant contenir des données doubles (bool int float string)
     * getOneScalarResult = idem mais un seul resultat
     * getArrayResult = retourne des resultats sous forme de tableau imbriqué au lieu de retourné un ArrayCollection
     */

    public function getAnnonceByUser($utilisateurs){
        $query =  $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC');
        if($utilisateurs){
            $query = $query
                ->andWhere('a.utilisateurs = :utilisateurs')
                ->setParameter('utilisateurs', $utilisateurs);
        }
        return $query->getQuery()->getResult();

    }

    public function searchParameters($prix, $cat,$region){

        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC');

        if($prix){
            $query = $query
                ->andWhere('a.prixAnnonces < :prixMax')
                ->setParameter('prixMax', $prix);
        }

        if($cat){
            $query = $query
                ->andWhere('a.categories = :categorieID')
                ->setParameter('categorieID', $cat);
        }

        if($region){
            $query = $query
                ->andWhere('a.regions = :regionID')
                ->setParameter('regionID', $region);
        }
        return $query->getQuery()->getResult();

    }



    public function annonceTriDecroissant(){
        return $this->createQueryBuilder('annonce')
            ->orderBy('annonce.id','DESC')
            ->getQuery()
            ->getResult();
    }


    public function triParPrix(int $prix){
        return $this->createQueryBuilder('annonces')
            ->where('annonces.prixAnnonces > :prix')
            ->setParameter('prix', $prix)
            ->orderBy('annonces.prixAnnonces', 'ASC')
            ->getQuery()
            ->getResult();
    }




    /*
     public function countAnnonce(){
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    */
}
