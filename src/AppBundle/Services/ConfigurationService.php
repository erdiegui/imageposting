<?php

namespace AppBundle\Services;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\ConfigurationRepository;
use AppBundle\Entity\Image;
use AppBundle\Entity\ImageRepository;
use AppBundle\Form\ReplyFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfigurationService
 * @package AppBundle\Services
 */
class ConfigurationService
{
    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ConfigurationService constructor.
     * @param ConfigurationRepository $configurationRepository
     * @param EntityManager $em
     */
    public function __construct(ConfigurationRepository $configurationRepository, EntityManager $em)
    {
        $this->configurationRepository = $configurationRepository;
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getSiteConfiguration() {

        return $this->configurationRepository->getConfiguration();
    }

    /**
     * @param Configuration $configuration
     * @return Configuration
     */
    public function addView(Configuration $configuration) {

        $views = $configuration->getViews();
        $configuration->setViews($views + 1);

        $this->em->persist($configuration);
        $this->em->flush();

        return $configuration;
    }
}