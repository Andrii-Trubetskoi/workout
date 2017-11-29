<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorys = $em->getRepository('AppBundle:Category')->findAll();
        $categorysFilter = $em->getRepository('AppBundle:Category')->findCategoryByName($request);

        return $this->render('default/index.html.twig', [
            'categorys' => $categorys,
            'categorysFilter' => $categorysFilter,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);

    }
}
