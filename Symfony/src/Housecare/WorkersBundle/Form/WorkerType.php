<?php

namespace Housecare\WorkersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Housecare\WorkersBundle\Entity\Worker;

class WorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
       $listOfQualif = array('choices' => Worker::$listOfQualif);
       $listOfStatut = array('choices' => Worker::$listOfStatut);
       
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('position')
            ->add('note')
            ->add('statut', 'choice', $listOfStatut)
            ->add('zipCode')
            ->add('qualification', 'choice', $listOfQualif)
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Housecare\WorkersBundle\Entity\Worker'
        ));
    }

    public function getName()
    {
        return 'housecare_workersbundle_workertype';
    }
}
