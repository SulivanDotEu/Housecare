<?php

namespace Housecare\CostumersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CostumersType extends AbstractType {
   
   public $countryManager;

   function __construct($serviceCountryManager) {
      $this->countryManager = $serviceCountryManager;
   }

   public function buildForm(FormBuilderInterface $builder, array $options) {

      //$countryManager = $this->container->get('housecare.CountryManager');
      /* @var $countryManager \Housecare\CostumersBundle\Country\CountryManager */
      $countries = $this->countryManager->getCountries();
      $choices = array(
          'choices' => $countries);

      $builder
              ->add('lastName')
              ->add('firstName')
              ->add('phone')
              ->add('street')
              ->add('number')
              ->add('zipCode')
              ->add('city')
              ->add('country', 'choice', $choices)
              ->add('note');
   }

   public function setDefaultOptions(OptionsResolverInterface $resolver) {
      $resolver->setDefaults(array(
          'data_class' => 'Housecare\CostumersBundle\Entity\Costumers'
      ));
   }

   public function getName() {
      return 'housecare_costumersbundle_costumerstype';
   }

}
