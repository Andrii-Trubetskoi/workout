<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function indexAction()
    {
        return new Response('<h1>category list</h1>');
    }

    public function createAction(Request $request)
    {
        $params = [];
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $category = new Category();

        $category->setName($params['name']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return new Response($category);
    }

    public function editAction(Request $request)
    {

    }
}