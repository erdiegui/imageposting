<?php

namespace AppBundle\Controller;

use AppBundle\Form\ReplyFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ImageService;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $form = $this->get('form.factory')->create(ReplyFormType::class);

        /** @var ImageService $imageService */
        $imageService = $this->get('instagram.image.service');

        /** @var array $images */
        $images = $imageService->getAllImages();

        return $this->render('default/index.html.twig', [
            'images'    => $images,
            'form'      => $form->createView(),
        ]);
    }
}
