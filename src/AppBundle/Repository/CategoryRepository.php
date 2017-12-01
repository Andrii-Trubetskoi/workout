<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findCategoryByName($request)
    {
        $result = [];
        $qb = $this->createQueryBuilder('category');
        $qName = $request->query->get('q_name');
        $qDate = $request->query->get('q_date');

        if ($qDate) {
            $qDate = date_create_from_format('Y-m-d', $qDate);
        }

        if ($qName && !$qDate) {
            $qb
                ->where('category.name = :name')
                ->setParameter(':name', $qName);
            $result = $qb->getQuery()->getResult();
        } elseif ($qDate && !$qName) {
            $qb
                ->where('category.date = :date')
                ->setParameter(':date', $qDate);
            $result = $qb->getQuery()->getResult();
        } elseif ($qDate && $qName) {
            $qb
                ->where('category.date = :date')
                ->andWhere('category.name = :name')
                ->setParameter(':date', $qDate)
                ->setParameter(':name', $qName);
            $result = $qb->getQuery()->getResult();
        }

        return $result;
    }
}
