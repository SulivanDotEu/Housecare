<?php

namespace Housecare\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Housecare\JobBundle\Entity\Job;

class JobType extends AbstractType {

   public function buildForm(FormBuilderInterface $builder, array $options) {

      $listOfTypes = array('choices' => Job::$listOfTypes);
      
      $listOfSubtypes = array(
          'choices' => Job::$listOfSubtypes);
      $listOfTimeNeeded = array(
          'choices' => Job::$listOfTimeNeeded);
      $listOfThanksTo = array(
          'choices' => Job::$listOfThanksTo);

      $builder
              ->add('description')
              ->add('type', 'choice', $listOfTypes)
              ->add('subtype', 'choice', $listOfSubtypes)
              ->add('timeNeeded', 'choice', $listOfTimeNeeded)
              ->add('thanksTo', 'choice', $listOfThanksTo)
      ;
   }

   public function setDefaultOptions(OptionsResolverInterface $resolver) {
      $resolver->setDefaults(array(
          'data_class' => 'Housecare\JobBundle\Entity\Job'
      ));
   }

   public function getName() {
      return 'housecare_jobbundle_jobtype';
   }

}
