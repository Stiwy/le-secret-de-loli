<?php

namespace App\Repository;

use App\Entity\Reference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reference[]    findAll()
 * @method Reference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reference::class);
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findProductByPrimaryReference($value)
    {
        return $this->createQueryBuilder('r')
            ->select('r', 'p')
            ->join('r.product', 'p')
            ->andWhere('p.slug = :val')
            ->andWhere('r.isPrimary = true')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findAllReferencesOfProduct($value)
    {
        return $this->createQueryBuilder('r')
            ->select('r', 'p')
            ->join('r.product', 'p')
            ->andWhere('p.slug = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findProductByReference($slug, $reference)
    {
        return $this->createQueryBuilder('r')
            ->select('r', 'p')
            ->join('r.product', 'p')
            ->andWhere('p.slug = :slug')
            ->andWhere('r.reference = :reference')
            ->setParameter('slug', $slug)
            ->setParameter('reference', $reference)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Reference[] Returns an array of Reference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reference
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
