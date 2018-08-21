<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Owner::class);
    }


    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('owner')
            ->orderBy('owner.name', 'ASC');
    }

    /**
     * @param null|string $term
     * @return Owner[]
     */
    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('o');

        if ($term) {
            $qb->andWhere('o.name LIKE :term OR o.email LIKE :term OR o.address LIKE :term OR o.telephone LIKE :term')
                ->setParameter('term', '%' . $term . '%');

        }
        return $qb->orderBy('o.name', 'DESC')->getQuery()->getResult();

    }

//    /**
//     * @return Owner[] Returns an array of Owner objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Owner
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
