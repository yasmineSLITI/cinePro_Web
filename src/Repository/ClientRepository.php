<?php

namespace App\Repository;

use App\Entity\Client;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;




use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Client $entity, bool $flush = true): void
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
    public function remove(Client $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Client[] Returns an array of Client objects

    // /**
    //  * @return Classeroom[] Returns an array of Classeroom objects

    //  */
    /*
    public function findByExampleField($value)
=======
    // /**
    //  * @return Publication[] Returns an array of Classeroom objects
    //  */
    /*
    public function findByid($)

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

    public function findOneBySomeField($value): ?Client
=======
    public function findOneBySomeField($value): ?Classeroom
>>>>>>> salmafinal
=======
    public function findOneBySomeField($value): ?Classeroom
>>>>>>> sarrour
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
 public function getRole(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("Select c.role FROM APP\Entity\Panier p , APP\Entity\client c  where p.idclient = c.idclient  ")
          ;
        return $query->getResult();
    }
 }

   

   
    




