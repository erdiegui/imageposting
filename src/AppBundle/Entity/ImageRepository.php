<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ImageRepository
 * @package AppBundle\Entity
 */
class ImageRepository extends EntityRepository
{
    public function getAllImages() {

        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $dql = " SELECT i
                FROM AppBundle:Image i
                ORDER BY i.id DESC";
        $query = $em->createQuery($dql);
        $res = $query->getArrayResult();

        return $res;

    }
}