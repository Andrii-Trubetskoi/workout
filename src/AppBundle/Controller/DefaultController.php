<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categorys = $em->getRepository('AppBundle:Category')->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'categorys' => $categorys,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);

    }
}
