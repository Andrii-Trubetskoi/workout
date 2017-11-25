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
        $category = new Category();

        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_create');
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, Category $category)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
            $category->setName($params['name']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new Response($category);
        }

        return new Response('<h1>Have no content</h1>');
    }

    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new Response('<h1>Category was deleted</h1>');
    }
}
