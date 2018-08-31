<?php

namespace App\Repository;

use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Entity\Staff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
     */
    public function getForOwnerWithQueryBuilder(?string $term, Staff $staff): QueryBuilder
    {
        if($term != null) {
            $qb = $this->createQueryBuilder('l')
                ->innerJoin('l.staff', 's')
                ->addSelect('s')
                ->innerJoin('l.owner', 'o')
                ->addSelect('o')
                ;

            if ($term) {
                $qb->andWhere('l.log LIKE :term OR l.publishedAt LIKE :term OR l.details LIKE :term OR s.name LIKE :term OR o.name LIKE :term')->setParameter('term', '%' . $term . '%');
                $qb->andWhere('s.email LIKE :staff')->setParameter('staff', $staff->getEmail());
            }
            return $qb->orderBy('l.publishedAt', 'DESC');
        }
        else{
            $qb = $this->createQueryBuilder('a')
                ->andWhere('a.staff = :val')
                ->setParameter('val', $staff);
            return $qb->orderBy('a.publishedAt', 'DESC');
        }
    }

    /**
     * @param null|string $term
     */
    public function getWithQueryBuilder(?string $term, Staff $staff): QueryBuilder
    {
        if($term != null) {
            $qb = $this->createQueryBuilder('l')
                ->innerJoin('l.staff', 's')
                ->addSelect('s')
                ->innerJoin('l.owner', 'o')
                ->addSelect('o')
                ->innerJoin('o.properties', 'p')
                ->addSelect('p');

            if ($term) {
                $qb->andWhere('l.log LIKE :term OR l.publishedAt LIKE :term OR l.details LIKE :term OR s.name LIKE :term OR o.name LIKE :term OR p.name LIKE :term')->setParameter('term', '%' . $term . '%');
                $qb->andWhere('s.email LIKE :staff')->setParameter('staff', $staff->getEmail());
            }
            return $qb->orderBy('l.publishedAt', 'DESC');
        }
        else{
            $qb = $this->createQueryBuilder('a')
                ->andWhere('a.staff = :val')
                ->setParameter('val', $staff);
            return $qb->orderBy('a.publishedAt', 'DESC');
        }
    }

    /**
     * @param null|string $term
     */
    public function getWithSearchQueryBuilder(?string $term, Owner $owner): QueryBuilder
    {
        if($term != null) {
            $qb = $this->createQueryBuilder('l')
                ->innerJoin('l.staff', 's')
                ->addSelect('s')
                ->innerJoin('l.owner', 'o')
                ->addSelect('o')
                ->innerJoin('s.staffType', 't')
                ->addSelect('t')
                ->innerJoin('o.properties', 'p')
                ->addSelect('p')
            ;

            if ($term) {
                $qb->andWhere('l.log LIKE :term OR l.publishedAt LIKE :term OR l.details LIKE :term OR s.name LIKE :term OR o.name LIKE :term OR t.type LIKE :term OR p.name LIKE :term')->setParameter('term', '%' . $term . '%');
                $qb->andWhere('o.email LIKE :owner')->setParameter('owner', $owner->getEmail());
            }
            return $qb->orderBy('l.publishedAt', 'DESC');
        }
        else{
            $qb = $this->createQueryBuilder('a')
                ->innerJoin('a.owner', 'o')
                ->andWhere('o.email LIKE :val')
                ->setParameter('val', $owner->getEmail());
            return $qb->orderBy('a.publishedAt', 'DESC');
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
