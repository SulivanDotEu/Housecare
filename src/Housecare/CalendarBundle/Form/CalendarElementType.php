<?php

namespace Housecare\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Housecare\CalendarBundle\Entity\CalendarElement;

class CalendarElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
       $listOfColor = array('choices' => CalendarElement::$LIST_OF_COLOR);
       
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('color', 'choice', $listOfColor)
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Housecare\CalendarBundle\Entity\CalendarElement'
        ));
    }

    public function getName()
    {
        return 'housecare_calendarbundle_calendarelementtype';
    }
}
