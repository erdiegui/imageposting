<?php

namespace AppBundle\Services;

use AppBundle\Entity\Image;
use AppBundle\Entity\ImageRepository;
use AppBundle\Form\ReplyFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

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
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $mediaSymlink;

    /**
     * ImageService constructor.
     * @param ImageRepository $imageRepository
     * @param FormFactory $formFactory
     * @param EntityManager $em
     * @param $mediaSymlink
     */
    public function __construct(ImageRepository $imageRepository, FormFactory $formFactory, EntityManager $em, $mediaSymlink)
    {
        $this->imageRepository = $imageRepository;
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->mediaSymlink = $mediaSymlink;
    }

    /**
     * @return array
     */
    public function getAllImages() {

        return $this->imageRepository->getAllImages();
    }


    /**
     * @param Request $request
     * @return array
     */
    public function createImage(Request $request) {
        /** @var Image $image */
        $image = new Image();
        $imageForm = $this->formFactory->create(ReplyFormType::class, $image)
            ->remove('saveSubmit')
            ->remove('image');

        $imageForm->handleRequest($request);


        if (!$imageForm->isValid()) {
            return array(
                'isError' => true,
                'errDesc' => 'File upload error'
            );
        }

        $this->handleImageUpload($image);
        $this->em->persist($image);
        $this->em->flush($image);

        return array(
            'isError' => false,
            'errDesc' => ''
        );
    }


    /**
     * @param Image $image
     */
    private function handleImageUpload(Image $image)
    {
        if (null === $image->getImageFile()) {
            return;
        }

//        $uploadPreference = $this->em->getRepository('VocentoOferplanBundle:UploadPreferences')
//            ->findOneBy(array('name' => self::PRE_GENERATED_COUPON_CODES));
//
//        if(!$uploadPreference){
//            throw new \RuntimeException('No preferences found');
//        }
        $pathStringFromDate = $this->getPathStringFromDate(new \DateTime('now'));
        $uploadDir = $this->mediaSymlink. $pathStringFromDate;

        $image->getImageFile()->move(
            $uploadDir,
            $image->getImageFile()->getClientOriginalName()
        );

        $image->setImage(ltrim($pathStringFromDate, '/').'/'.$image->getImageFile()->getClientOriginalName());
        $image->setImageFile(null);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    private function getPathStringFromDate(\DateTime $date)
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        return '/'.$year.'/'.$month.'/'.$day;
    }
}