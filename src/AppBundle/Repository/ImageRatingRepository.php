<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class ImageRatingRepository extends EntityRepository
{
    public function findRatedImagesByUser($userId, $limit = Image::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('r')
            ->join('r.image', 'i')
            ->select('i.imageUrl', 'i.id', 'i.rating')
            ->where('r.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('r.id', 'DESC')
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function countImageRating($imageId)
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.user) as rating')
            ->where('r.image = :image')
            ->setParameter('image', $imageId)
            ->getQuery()->getSingleScalarResult();
    }
}