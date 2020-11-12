<?php

namespace App\Repository;

use App\Entity\Blogdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blogdata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blogdata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blogdata[]    findAll()
 * @method Blogdata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogdataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blogdata::class);
    }

    // /**
    //  * @return Blogdata[] Returns an array of Blogdata objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Blogdata
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function  getBlogData($UserID)
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.created_by = :user_id')
        ->setParameter('created_by', $UserID)
        ->orderBy('b.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
    }
    public function findBlog($blogId)
    {
        return $this->createQueryBuilder('b')
                    ->andWhere('b.id = :blogid')
                    ->setParameter('blogid',$blogId)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
    public function getBlogsByUser($value)
    {   
        // $qb = $this->createQueryBuilder('b');
        // return $qb;
        return $this->createQueryBuilder('b')
                        ->andWhere('b.created_by = :val')
                        ->setParameter('val', $value)
                        ->getQuery();
                       // ->getResult();
        
    }
    public function  getBlogById($blogId,$loggedUser)
    {
        return $this->createQueryBuilder('b')
                        ->andWhere('b.created_by = :created_by')
                        ->setParameter('created_by', $loggedUser)
                        ->andWhere('b.id = :blogid')
                        ->setParameter('blogid', $blogId)
                        ->getQuery()
                        ->getResult();
    }
}
