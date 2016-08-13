<?php

namespace AppBundle\Services;

use AppBundle\Entity\Image;
use AppBundle\Services\ImageService;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class DownloadService
 * @package AppBundle\Services
 */
class DownloadService
{

    const CSV_FILE_PREFIX_NAME = 'export_';
    const CSV_EXTENSION = '.csv';

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @var string
     */
    protected $mediaDir;

    /**
     * @var string
     */
    protected $mediaSymlink;

    /**
     * DownloadService constructor.
     * @param \AppBundle\Services\ImageService $imageService
     * @param $mediaDir
     * @param $mediaSymlink
     */
    public function __construct(ImageService $imageService, $mediaDir, $mediaSymlink)
    {
        $this->imageService = $imageService;
        $this->mediaDir = $mediaDir;
        $this->mediaSymlink = $mediaSymlink;
    }

    /**
     * @return StreamedResponse
     */
    public function generateCsv() {

        $fileName = self::CSV_FILE_PREFIX_NAME . time() . self::CSV_EXTENSION;
        $handle = fopen($this->mediaDir . "/" . $fileName, 'w+');

        fputcsv($handle, array('Title', 'Image'),';');

        /** @var array $images */
        $images = $this->imageService->getAllImages();

        /** @var Image $image */
        foreach ($images as $image) {
            fputcsv(
                $handle,
                array($image['title'], $image['image']),
                ';'
            );
        }
        fclose($handle);

        return $this->mediaSymlink . $fileName;

//        $response = new StreamedResponse();
//        $response->setCallback(function() {
//
//
//        });
//
//        $fileName = $this->mediaSymlink . self::CSV_FILE_NAME;
//        $response->setStatusCode(200);
//        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
//        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName . '"');
//
//        return $response;
    }
}