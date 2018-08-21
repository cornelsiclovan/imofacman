<?php

namespace App\Repository;

use App\Entity\StaffType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StaffType|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffType|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffType[]    findAll()
 * @method StaffType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StaffType::class);
    }


    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('staff_type')
            ->orderBy('staff_type.type', 'ASC');
    }

    /**
     * @param null|string $term
     * @return StaffType[]
     */
    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('t');

        if ($term) {
            $qb->andWhere('t.type LIKE :term')
                ->setParameter('term', '%' . $term . '%');

        }
        return $qb->orderBy('t.type', 'ASC')->getQuery()->getResult();

    }
//    /**
//     * @return StaffType[] Returns an array of StaffType objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StaffType
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
