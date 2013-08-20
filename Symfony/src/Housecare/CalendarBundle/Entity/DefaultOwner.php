<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultOwner
 *
 * @author Teta
 */

namespace Housecare\CalendarBundle\Entity;
use Housecare\CalendarBundle\Entity\CalendarElementOwnerInterface;


class DefaultOwner implements CalendarElementOwnerInterface  {
   //put your code here
   
   private static $_instance = null;
   
   private function __construct() {
      return $this;
   }
   
   public static function getInstance(){
      if(self::$_instance == null){
         self::$_instance = new DefaultOwner();
      }
      return self::$_instance;
   }
   
   public function configureCalendarElement(CalendarElement $calendarElement){
      $calendarElement->setTitle("Default Owner");
   }
   
   public function getCalendarHeader(){
      return "Default Owner Header";
   }
}

?>
