<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findCategoryByName($request)
    {
        $result = [];
        $qb = $this->createQueryBuilder('category');
        $q = $request->query->get('q_name');
        $q_date = $request->query->get('q_date');

        if ($q_date) {
            $q_date = date_create_from_format('Y-m-d', $q_date);
        }

        if ($q && !$q_date) {
            $qb
                ->where('category.name = :name')
                ->setParameter(':name', $q);
            $result = $qb->getQuery()->getResult();
        } elseif ($q_date && !$q) {
            $qb
                ->where('category.date = :date')
                ->setParameter(':date', $q_date);
            $result = $qb->getQuery()->getResult();
        } elseif ($q_date && $q) {
            $qb
                ->where('category.date = :date')
                ->andWhere('category.name = :name')
                ->setParameter(':date', $q_date)
                ->setParameter(':name', $q);
            $result = $qb->getQuery()->getResult();
        }

        return $result;
    }
}
