<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Category;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SearchCategory
{
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Category) {
            return;
        }

        if (count($entity->getExercises())) {
            throw new \Exception('There are exercises in this category');
        }
    }
}
