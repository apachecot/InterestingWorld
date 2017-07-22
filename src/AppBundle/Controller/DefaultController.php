<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Landing page
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();

        $images = $em->getRepository('AppBundle:Image')->findLastImages();

        return $this->render('default/index.html.twig', array('images' => $images));
    }

    /**
     * Change langugage
     * @Route("/language/{locale}", name="changeLanguage")
     */
    public function changeLanguageAction(Request $request, $locale)
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('homepage');
    }
}
