<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    const LIMIT = 10;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function add(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function getQBAllCommentsOrderByDate($value): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->where('c.tricks = :val')
            ->setParameter('val', $value)
            ->orderBy('c.createdAt', 'ASC');
    }

    public function getPaginator($value, int $page): Paginator
    {
        $paginator = new Paginator($this->getQBAllCommentsOrderByDate($value));
        $paginator
           ->getQuery()
           ->setFirstResult(self::LIMIT * ($page - 1))
           ->setMaxResults(self::LIMIT);

        return $paginator;
    }
}
