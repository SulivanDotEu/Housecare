<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Teta
 */

namespace Housecare\CalendarBundle\CalendarRender;
use Housecare\CalendarBundle\CalendarRender\CalendarRender;


interface CalendarRenderCellDelegateInterface {
   //put your code here
   
   public function prepare(CalendarRender $cr);
   public function getDistanceAt($hour, $minute);
   public function setOwner($owner);
   
}

?>
