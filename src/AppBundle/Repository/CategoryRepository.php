<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findCategoryByName($request)
    {
        $qb = $this->createQueryBuilder('category');
        $qName = $request->query->get('q_name');
        $qDate = $request->query->get('q_date');

        if ($qName) {
            $qb
                ->andWhere('category.name = :name')
                ->setParameter(':name', $qName);
        }

        if ($qDate) {
            $qDate = date_create_from_format('Y-m-d', $qDate);
            $qb
                ->andWhere('category.date = :date')
                ->setParameter(':date', $qDate);
        }

        return $qb->getQuery()->getResult();
    }
}
