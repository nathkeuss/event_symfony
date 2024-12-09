<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function findByEstablishmentId($establishment_id): array
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT *
                FROM image
                INNER JOIN room ON room.id = image.room_id
                WHERE room.establishment_id = :establishment_id
                ')
            ->setParameter('establishment_id', $establishment_id)
            ->getResult();
    }
}
