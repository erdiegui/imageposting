<?php

namespace AppBundle\Model;

/**
 * Class Image
 * @package AppBundle\Model
 */
class Image implements \JsonSerializable, \Serializable
{
    /**
     * @var
     */
    private $image;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $extension;

    /**
     * CampaignImage constructor.
     * @param $image
     * @param $extension
     * @param $size
     */
    public function __construct($image = null, $extension = null, $size = null)
    {
        $this->image = $image;
        $this->extension = $extension;
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function jsonSerialize()
    {
        return [
            'image'     => $this->image,
            'size'      => $this->size,
            'extension' => $this->extension,
        ];
    }

    public function serialize()
    {
        return serialize( [
            'image'     => $this->image,
            'size'      => $this->size,
            'extension' => $this->extension,
        ]);
    }

    public function unserialize($serialized)
    {
        $uns = unserialize($serialized);
        $this->image = $uns['image'];
        $this->size = $uns['size'];
        $this->extension = $uns['extension'];
    }
}