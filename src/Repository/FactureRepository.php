<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    private $paginator ; 
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Facture::class);
        $this->paginator = $paginator;
    }


    // /**
    //  * @return Classeroom[] Returns an array of Classeroom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Classeroom
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function ListeFacture(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("Select s  FROM APP\Entity\Facture s Where s.idfacture=1");
          
        return $query->getResult();
    }
    public function orderByTotal(SearchData $search)
    {
        $query = $this->createQueryBuilder('p')
          ->orderBy('p.datecreation', 'ASC');
  
          if (!empty($search->q)) {
              $query = $query->Where('p.datecreation LIKE :q or p.total LIKE :q')
                             ->andWhere('p.total LIKE :q')
                  ->setParameter('q', "%{$search->q}%");
          } 
          $query = $query->getQuery();
          return $this->paginator->paginate(
              $query,
              $search->page,
              2);
  
    }
     /**
      * @return PaginationInterface
      */
   
      public function findSearch(SearchData $search)
      {
         
          $query = $this->createQueryBuilder('p')
          ->orderBy('p.total', 'ASC');
  
          if (!empty($search->q)) {
              $query = $query->Where('p.datecreation LIKE :q')
  
                  ->setParameter('q', "%{$search->q}%");
          } 
          $query = $query->getQuery();
          return $this->paginator->paginate(
              $query,
              $search->page,
              2);
  
  }
  public function viderFacture(){
    $entityManager=$this->getEntityManager();
    $query=$entityManager
        ->createQuery("Delete  FROM APP\Entity\Facture p WHERE p.idpanier = 1")
      ;
    return $query->getResult();
}
}
