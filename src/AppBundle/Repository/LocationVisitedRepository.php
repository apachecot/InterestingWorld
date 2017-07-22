<?php

namespace AppBundle\Repository;

use ApiBundle\Util\MapUtil;
use AppBundle\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class LocationVisitedRepository extends EntityRepository
{
    public function findLocationsVisitedByUser($userId, $limit = Location::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('v')
            ->where('v.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('v.id', 'DESC')
            ->setFirstResult($limit * ($page - 1) )
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }
}