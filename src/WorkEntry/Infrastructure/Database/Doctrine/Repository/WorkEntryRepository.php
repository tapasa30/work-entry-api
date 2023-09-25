<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Database\Doctrine\Repository;

use App\WorkEntry\Domain\Entity\WorkEntry;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkEntry>
 *
 * @method WorkEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkEntry[]    findAll()
 * @method WorkEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkEntryRepository extends ServiceEntityRepository implements WorkEntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkEntry::class);
    }

    public function save(WorkEntry $workEntry): void
    {
        $this->getEntityManager()->persist($workEntry);
        $this->getEntityManager()->flush();
    }

    public function getActiveByUserId(int $userId): ?WorkEntry
    {
        $queryBuilder = $this->createQueryBuilder('work_entry');

        return $queryBuilder
            ->innerJoin('work_entry.user', 'user')
            ->where($queryBuilder->expr()->isNull('work_entry.endDate'))
            ->andWhere($queryBuilder->expr()->isNull('work_entry.deletedAt'))
            ->andWhere($queryBuilder->expr()->eq('user.id', ':user_id'))
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getById(int $id): ?WorkEntry
    {
        $queryBuilder = $this->createQueryBuilder('work_entry');

        return $queryBuilder
            ->where($queryBuilder->expr()->isNull('work_entry.deletedAt'))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
