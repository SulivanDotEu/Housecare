<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjectComparator
 *
 * @author Teta
 */

namespace Housecare\JobBundle\Comparator;


class ObjectComparator {
   //put your code here
   
   public static $ASC = 1;
   public static $DESC = 0;
   private $property;
   
   public function sort($objects, $property){
      $this->setProperty($property);
      usort($objects, array($this, "compare"));

   }
   
   public function compare($a, $b){
      $method = "get".ucfirst($this->getProperty());
      $a = $a->$method();
      $b = $b->$method();
      if($a == $b) return 0;
      return ($a < $b) ? -1 : 1;
   }
   
   public function getProperty() {
      return $this->property;
   }

   public function setProperty($property) {
      $this->property = $property;
   }


}

?>
