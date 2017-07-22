<?php

namespace AppBundle\Repository;

use ApiBundle\Util\MapUtil;
use AppBundle\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class LocationRatingRepository extends EntityRepository
{
    public function countLocationRating($locationId)
    {
       return $this->createQueryBuilder('r')
           ->select('count(r.location)')
           ->where('r.location = :location')
           ->setParameter('location', $locationId)
           ->getQuery()->getSingleScalarResult();
    }

    public function findLocationsRatedByUser($userId, $limit = Location::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('r.id', 'DESC')
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function countAllLocationsRating()
    {
        return $this->createQueryBuilder('r')
            ->groupBy('r.location')
            ->getQuery()->getSingleScalarResult();
    }
}