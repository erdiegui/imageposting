<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuration;
use AppBundle\Form\ReplyFormType;
use AppBundle\Services\ConfigurationService;
use AppBundle\Services\DownloadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ImageService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var ImageService $imageService */
        $imageService = $this->get('instagram.image.service');

        $replyForm = $request->get('reply_form');

        /** @var ConfigurationService $configurationService */
        $configurationService = $this->get('instagram.configuration.service');

        /** @var Configuration $siteConfiguration */
        $siteConfiguration = $configurationService->getSiteConfiguration();

        $errorsFound = null;
        if ($replyForm) {
            $errorsFound = $imageService->createImage($request);
        } else {
            /** @var Configuration $siteConfiguration */
            $siteConfiguration = $configurationService->addView($siteConfiguration);
        }

        $form = $this->get('form.factory')->create(ReplyFormType::class);

        /** @var array $images */
        $images = $imageService->getAllImages();

        return $this->render('default/index.html.twig', [
            'images'    => $images,
            'form'      => $form->createView(),
            'errorsFound' => $errorsFound,
            'configuration' => $siteConfiguration
        ]);
    }

    /**
     * @Route("/export/csv", name="generateCsv")
     * @return StreamedResponse
     */
    public function generateCsvAction()
    {
        /** @var DownloadService $downloadService */
        $downloadService = $this->get('instagram.generate.download');
        $fileName = $downloadService->generateCsv();

//        return $response;
        return new RedirectResponse($fileName);
    }


}
