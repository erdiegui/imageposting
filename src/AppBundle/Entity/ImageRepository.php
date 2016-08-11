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

        return $em->getRepository(Image::class)->findAll();
    }
}