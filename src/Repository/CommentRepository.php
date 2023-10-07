<?php

namespace App\Repository;

use App\Entity\Figure;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    //    /**
    //     * @return Comment[] Returns an array of Comment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function loadMoreComments(Figure $figure, $start, EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();

        $qb->add('select', 'c')
            ->add('from', 'App\Entity\Comment c')
            ->add('where', 'c.figure = :figureId')
            ->add('orderBy', 'c.id DESC')
            ->setFirstResult($start)
            ->setMaxResults(2)
            ->setParameter('figureId', $figure->getId());

        $query = $qb->getQuery();
        $result = $query->getResult();

        $data = [];
        $lenght = count($result);

        for ($i = 0; $i < $lenght; $i++) {
            $newComment = [
                "name" => $result[$i]->getUser()->getUsername(),
                "content" => $result[$i]->getContent()
            ];

            $date = $result[$i]->getDate();
            $newComment["date"] = $date->format('d-m-Y');

            array_push($data, $newComment);
        }

        return $data;
    }
}
