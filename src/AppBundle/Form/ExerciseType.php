<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
            ));
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
