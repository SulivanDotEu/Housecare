<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountryManager
 *
 * @author Teta
 */

namespace Housecare\CostumersBundle\Country;
 

class CountryManager {
   
   private $tableDesPays;
   
   //put your code here
   public function __construct() {
      $this->tableDesPays = array(
          'Belgium', 'France', 'England', 'Nederlands', 'Switzerland', 'Luxembourg'
      );
   }
   
   public function getCountries(){
      
      return $this->tableDesPays;
   }

   
}

?>
