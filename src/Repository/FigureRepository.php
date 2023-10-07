<?php

namespace App\Repository;

use App\Entity\Figure;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Figure>
 *
 * @method Figure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Figure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Figure[]    findAll()
 * @method Figure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FigureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Figure::class);
    }

    //    /**
    //     * @return Figure[] Returns an array of Figure objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Figure
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function loadMoreCards($start, EntityManagerInterface $em): array
    {
        $qb = $em->createQueryBuilder();

        $qb->add('select', 'f')
            ->add('from', 'App\Entity\Figure f')
            ->add('orderBy', 'f.id ASC')
            ->setFirstResult($start)
            ->setMaxResults(3);

        $query = $qb->getQuery();
        $result = $query->getResult();

        $data = [];
        $lenght = count($result);

        for ($i = 0; $i < $lenght; $i++) {
            $newFigure = [
                "name" => $result[$i]->getName(),
                "slug" => $result[$i]->getSlug()
            ];

            if ($result[$i]->getBanner() === null) {
                $newFigure['media_path'] = '';
            } else {
                $newFigure['media_path'] = $result[$i]->getBanner()->getMediaPath();
            }

            array_push($data, $newFigure);
        }

        return $data;
    }
}
