<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }


    /**
     * @return Query
     */

    public function findActive(): Query
    {
        return $this->findVisibleQuery()
            ->andWhere('p.etat = true | false')
            ->getQuery();

    }

    /**
     * @return Query
     */
    public function findvisible(): Query
    {
        return $this->findVisibleQuery()
            ->getQuery();

    }

    /**
     * @return Projet[]
     */

    public function findLatest(): array
    {
        return $this->findVisibleQuery('p')
            ->andWhere('p.etat = true')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();


    }

    private function findVisibleQuery() : QueryBuilder{
        return $this->createQueryBuilder('p')
            ->andWhere('p.etat = true');
    }


    // /**
    //  * @return Projet[] Returns an array of Projet objects
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
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
