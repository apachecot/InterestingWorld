<?php

namespace AppBundle\Repository;

use ApiBundle\Util\MapUtil;
use AppBundle\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query as Query;

class LocationRepository extends EntityRepository
{
    public function findLastLocations($limit = Location::LIMIT, $page = 1)
    {
       return $this->createQueryBuilder('l')
           ->orderBy('l.id', 'DESC')
           ->setFirstResult($limit * ($page -1))
           ->setMaxResults($limit)
           ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findLocationsByUser($userId, $limit = Location::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('l')
            ->where('l.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('l.id', 'DESC')
            ->setFirstResult($limit * ($page -1))
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findLocationsByCategory($categoryId, $limit = Location::LIMIT, $page = 1)
    {
        return $this->createQueryBuilder('l')
            ->where('l.category = :category')
            ->setParameter('category', $categoryId)
            ->orderBy('l.id', 'DESC')
            ->setFirstResult($limit * ($page -1))
            ->setMaxResults($limit)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findNearestLocations($lat, $lng, $distance, $categoryId = null, $limit = 100)
    {
        $box = MapUtil::getBoundaries($lat, $lng, $distance);

        $categorySql = '';
        if ($categoryId != null) {

            $categorySql = 'AND category_id='.$categoryId.' ';
        }

        $sql = 'SELECT l.*,'.
            '( 6371 * ACOS(COS( RADIANS(' . $lat . ') ) * COS(RADIANS( lat ) ) * COS(RADIANS( lng ) '.
            '- RADIANS(' . $lng . ') ) + SIN( RADIANS(' . $lat . ') ) * SIN(RADIANS( lat ) ))'.
            ') AS distance '.
            'FROM location l '.
            'WHERE (l.lat BETWEEN ' . $box['min_lat']. ' AND ' . $box['max_lat'] . ') '.
            'AND (l.lng BETWEEN ' . $box['min_lng']. ' AND ' . $box['max_lng']. ') '
            . $categorySql .
            'ORDER BY distance ASC '.
            'LIMIT 0 , '.$limit;

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}