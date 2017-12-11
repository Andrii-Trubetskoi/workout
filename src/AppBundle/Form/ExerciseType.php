<?php

namespace AppBundle\Form;

use AppBundle\Entity\Exercise;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choicesCategory = [];
        $categorys = $this->em->getRepository('AppBundle:Category')->findAll();
        foreach ($categorys as $category) {
            $choicesCategory[$category->getName()] = $category;
        };

        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('date', DateTimeType::class, [
                'required' => false
            ])
            ->add('description', TextType::class, [
                'required' => false
            ])
            ->add('category', ChoiceType::class, array(
                'choices' => $choicesCategory,
            ))
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $newExercise = $event->getData();
                $exercise = $this->em->getRepository(Exercise::class)->findOneBy(['name' => $newExercise['name']]);
                if ($exercise) {
                    throw new Exception('There are Exercise with same name!');
                }
            });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Exercise',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'category';
    }
}
