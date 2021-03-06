<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Produit $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Produit $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Recherche les annonces en fonction du formulaire
     * @return void 
     */
    public function search($mots = null)
    {
        $query = $this->createQueryBuilder('a');
        if ($mots != null) {
            $query->andWhere('MATCH_AGAINST(a.designation, a.description) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSearch(SearchData $search): array
    {
        $query = $this->createQueryBuilder('p');

        if (!empty($search->q)) {
            $query = $query->where('p.designation LIKE :q')
                ->orWhere('p.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->min)) {
            $query = $query->andWhere('p.prixventeunit >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query->andWhere('p.prixventeunit <= :max')
                ->setParameter('max', $search->max);
        }

        return $query->getQuery()->getResult();
    }

    public function QuantiteVenduProduit($value): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

           'SELECT SUM(Panier.quantite) 
            FROM App\Entity\Produit Produit, App\Entity\Panier Panier 
            WHERE Produit.idproduit LIKE Panier.idproduit AND Panier.statuspanier =:status
            GROUP BY Produit.idproduit'
        )->setParameter('status', $value);

        // returns an array of Product objects
        return $query->getResult();
    }

    public function DesignationProduitVendu($value): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT Produit.designation 
            FROM App\Entity\Produit Produit, App\Entity\Panier Panier 
            WHERE Produit.idproduit LIKE Panier.idproduit AND Panier.statuspanier =:status
            GROUP BY Produit.idproduit'
        )->setParameter('status', $value);

        // returns an array of Product objects
        return $query->getResult();
    }
    public function getPrix()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery("Select p.prixventeunit  FROM APP\Entity\Produit p,APP\Entity\Panier pa where p.idproduit= pa.idproduit ");
        return $query->getSingleScalarResult();
    }
}
