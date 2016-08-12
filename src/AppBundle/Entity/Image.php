<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Image
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ImageRepository")
 * @ORM\Table(name="images")
 */
class Image
{
    /**
     * @var integer
     * @ORM\Column(name="id",type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="image_file", type="string", length=255)
     */
    private $imageFile;

    /**
     * @var integer
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param int $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

}