<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Database\Doctrine\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getById(int $id): ?User
    {
        $queryBuilder = $this->createQueryBuilder('user');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('user.id', ':user_id'))
            ->andWhere($queryBuilder->expr()->isNull('user.deletedAt'))
            ->setParameter('user_id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('user');

        return $queryBuilder
            ->where($queryBuilder->expr()->isNull('user.deletedAt'))
            ->getQuery()
            ->getResult();
    }
}
