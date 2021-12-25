<?php

namespace App\Repository;

use App\Entity\DepotTravail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepotTravail|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepotTravail|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepotTravail[]    findAll()
 * @method DepotTravail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepotTravailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepotTravail::class);
    }

    public function getTopNote($travail_code) {
        return $this->createQueryBuilder("d")
        ->where("d.travail = :val")
        ->setParameter('val',$travail_code)
        ->orderBy('d.note','DESC')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
    }
    // /**
    //  * @return DepotTravail[] Returns an array of DepotTravail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepotTravail
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
