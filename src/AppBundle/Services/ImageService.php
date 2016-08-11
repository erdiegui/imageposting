<?php

namespace AppBundle\Services;

use AppBundle\Entity\ImageRepository;

/**
 * Class ImageService
 * @package AppBundle\Services
 */
class ImageService
{
    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    /**
     * ImageService constructor.
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function getAllImages() {

        return $this->imageRepository->getAllImages();
    }
}