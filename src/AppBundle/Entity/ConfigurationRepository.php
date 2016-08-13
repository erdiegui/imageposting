<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ConfigurationRepository
 * @package AppBundle\Entity
 */
class ConfigurationRepository extends EntityRepository
{
    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getConfiguration() {

        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $dql = " SELECT c
                FROM AppBundle:Configuration c";

        $query = $em->createQuery($dql);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }
}