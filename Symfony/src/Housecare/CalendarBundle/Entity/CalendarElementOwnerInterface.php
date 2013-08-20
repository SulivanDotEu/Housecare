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

interface CalendarElementOwnerInterface {
   //put your code here
   
   public function getCalendarHeader();
}

?>
