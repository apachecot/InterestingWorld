<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class ImageRepository extends EntityRepository
{
    public function findLastImages($limit = Image::LIMIT, $page = 1)
    {
       return $this->createQueryBuilder('i')
           ->join('i.location', 'l')
           ->select('i.imageUrl as imageUrl', 'l.name as name')
           ->orderBy('i.id', 'DESC')
           ->setFirstResult($limit * ($page - 1) )
           ->setMaxResults($limit)
           ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findUploadedImagesByUser($userId, $limit = Image::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('i')
            ->select('i.imageUrl')
            ->where('i.user = :user')
            ->setParameter('user', $userId)
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findLocationImages($locationId, $limit = Image::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('i')
            ->select('i.imageUrl')
            ->where('i.location = :location')
            ->setParameter('location', $locationId)
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}