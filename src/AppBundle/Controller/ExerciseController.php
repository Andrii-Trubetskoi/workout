<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Exercise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function indexAction()
    {
        return new Response('<h1>exercises list</h1>');
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $request->request->get('data');

        $exercise = new Exercise();
        $categorys = $em->getRepository('AppBundle:Category')->findAll();

        $exercise->setCategory(reset($categorys));

        $form = $this->createForm('AppBundle\Form\ExerciseType', $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($exercise);
            $em->flush();

            return $this->redirectToRoute('exercise_create');
        }

        return $this->render('exercise/new.html.twig', array(
            'exercise' => $exercise,
            'categorys' => $categorys,
            'form' => $form->createView(),
        ));
    }

}