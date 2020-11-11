<?php

namespace App\Repository;

use App\Entity\CreatedOn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CreatedOn|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreatedOn|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreatedOn[]    findAll()
 * @method CreatedOn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreatedOnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreatedOn::class);
    }

    // /**
    //  * @return CreatedOn[] Returns an array of CreatedOn objects
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
    public function findOneBySomeField($value): ?CreatedOn
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
