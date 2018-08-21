<?php

namespace App\Repository;

use App\Entity\ActivityLog;
use App\Entity\Staff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityLog[]    findAll()
 * @method ActivityLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityLog::class);
    }

    /**
     * @param null|string $term
     * @return ActivityLog[]
     */
    public function findAllWithSearch(?string $term, Staff $staff)
    {
        if($term != null) {
            $qb = $this->createQueryBuilder('l')
                ->innerJoin('l.staff', 's')
                ->addSelect('s')
                ->innerJoin('l.owner', 'o')
                ->addSelect('o')
                ->innerJoin('l.property', 'p')
                ->addSelect('p');
            if ($term) {
                $qb->andWhere('l.log LIKE :term OR l.publishedAt LIKE :term OR l.details LIKE :term OR s.name LIKE :term OR o.name LIKE :term OR p.name LIKE :term')->setParameter('term', '%' . $term . '%');
                $qb->andWhere('s.email LIKE :staff')->setParameter('staff', $staff->getEmail());
            }
            return $qb->orderBy('l.publishedAt', 'DESC')->getQuery()->getResult();
        }
        else{
            return $this->findBy(['staff'=>$staff]);
        }
    }

//    /**
//     * @return ActivityLog[] Returns an array of ActivityLog objects
//     */
    public function findLogsByUserId($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.staff = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?ActivityLog
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
