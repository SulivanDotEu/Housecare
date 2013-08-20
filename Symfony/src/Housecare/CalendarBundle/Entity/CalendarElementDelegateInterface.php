<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalendarElementOwner
 *
 * @author Teta
 */

namespace Housecare\CalendarBundle\Entity;
use Housecare\CalendarBundle\Entity\CalendarElement;

use Doctrine\ORM\Mapping as ORM;

interface CalendarElementDelegateInterface {
   //put your code here
   
   public function configureCalendarElement(CalendarElement $calendarElement);
}

?>
