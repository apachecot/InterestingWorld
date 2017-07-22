<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class CommentRepository extends EntityRepository
{
    public function findLocationComments($locationId, $limit = Image::LIMIT, $page = 1)
    {
       return $this->createQueryBuilder('c')
           ->where('c.location = :location')
           ->setParameter('location', $locationId)
           ->orderBy('c.id', 'DESC')
           ->setFirstResult($limit * ($page - 1) )
           ->setMaxResults($limit)
           ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findUserComments($userId, $limit = Image::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('c.id', 'DESC')
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}