<?php

namespace ET\FrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findMailTargets()
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT u.email '
                . 'FROM FrontendBundle:User u JOIN u.userRole r '
                . 'WHERE (r.name = :role1) OR (r.name = :role2) AND (u.active = :active)';
        $query = $em->createQuery($dql);
        $query->setParameter('role1', 'ROLE_ADMIN');
        $query->setParameter('role2', 'ROLE_GED');
        $query->setParameter('active', true);

        return $query->getResult();
    }

    public function getQueryUsersByGedRole($name = '', $select = 'all', $workplace = null)
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.userRole', 'ur')
            ->leftJoin('u.student', 's')
            ->leftJoin('s.workplace', 'w');

        if ($select == 'all') {
            $query = $query->where('u.name LIKE :name OR u.surname LIKE :name OR u.email LIKE :name OR w.name LIKE :name OR w.code LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        } else {

            if ($workplace != null) {

                $query = $query->andWhere('w.id = :wid')->setParameter('wid', $workplace->getId());

            } else {

                $query = $query->where( $select.' LIKE :name')->setParameter('name', '%' . $name . '%');
            }
        }

        return $query->getQuery();
    }

    public function getQueryUsersByAdminRole($name = '', $select = 'all', $workplace = null)
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.userRole', 'ur')
            ->leftJoin('u.student', 's')
            ->leftJoin('s.workplace', 'w')
            ->where('ur.name != :role1')
            ->andWhere('ur.name != :role2')
            ->andWhere('ur.name != :role3')
            ->andWhere('u.active = :active')
            ->setParameter('role1', 'ROLE_GED')
            ->setParameter('role2', 'ROLE_ADMIN')
            ->setParameter('role3', 'ROLE_MANAGER')
            ->setParameter('active', true);

        if ($select == 'all') {
            $query = $query->andWhere('u.name LIKE :name OR u.surname LIKE :name OR u.email LIKE :name OR w.name LIKE :name OR w.code LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        } else {

            if ($workplace != null) {

                $query = $query->andWhere('w.id = :wid')->setParameter('wid', $workplace->getId());

            } else {

                $query = $query->andWhere( $select.' LIKE :name')->setParameter('name', '%' . $name . '%');
            }
        }

        return $query->getQuery();
    }

    public function getQueryUsersByResponsable($responsable, $name = '', $select = 'all', $accountName = '')
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.userRole', 'ur')
            ->leftJoin('u.student', 's')
            ->leftJoin('s.workplace', 'w')
            ->where('u.active = :active')
            ->innerJoin('w.responsable', 'r', 'WITH', 'r.id = :responsable')
            ->setParameter('responsable', $responsable)
            ->setParameter('active', true);

        if ($select == 'all') {
            $query = $query->andWhere('u.name LIKE :name OR u.surname LIKE :name OR u.email LIKE :name OR w.name LIKE :name OR w.code LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        } else {

            if ($accountName != '') {

                $query = $query->andWhere( $select.' LIKE :name')->setParameter('garage', '%' . $accountName . '%');

            } else {

                $query = $query->andWhere( $select.' LIKE :name')->setParameter('name', '%' . $name . '%');
            }
        }

        return $query->getQuery();
    }
}