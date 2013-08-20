<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalendarRender
 *
 * @author Teta
 */

namespace Housecare\CalendarBundle\CalendarRender;

use Housecare\CalendarBundle\Entity\CalendarElement;
use \Housecare\WorkersBundle\Entity\Worker;
use \DateTime;
use Housecare\CalendarBundle\CalendarRender\OdometerCellDelegate;

class CalendarRender {

   public static $CONST_HOUR = 'hour';
   public static $CONST_MINUTE = 'minute';

   /**
    *
    * @var \DateTime
    */
   public $date;
   public $day;
   public $month;
   public $year;
   public $table;
   public $listOfOwners;
   public $listOfOdometerCellDelegate;
   public $listOfCalendarElement;
   public $startHour = 1;
   public $endHour = 18;
   public $delatMinute = 20;
   public $controller;

   public function getDay() {
      if ($this->day == null) {
         $date = $this->getDate();
         $this->day = $date->format('d');
      }
      return $this->day;
   }

   public function getMonth() {
      if ($this->month == null) {
         $date = $this->getDate();
         $this->month = $date->format('m');
      }
      return $this->month;
   }

   public function getYear() {
      if ($this->year == null) {
         $date = $this->getDate();
         $this->year = $date->format('Y');
      }
      return $this->year;
   }

   public function getDate() {
      if ($this->date == null) {
         $this->date = new \DateTime;
      }
      return $this->date;
   }

   public function getDelatMinute() {
      return $this->delatMinute;
   }

   public function setDelatMinute($delatMinute) {
      $this->delatMinute = $delatMinute;
   }

   function __construct() {
      $this->table = array();
      $this->listOfOwners = array();
      $this->listOfCalendarElement = array();
      $this->listOfOdometerCellDelegate = array();
   }

   public function getCalendarElementsForOwner($owner) {
      $list = array();
      foreach ($listOfCalendarElement as $ce) {
         /* @var $ce CalendarElement */
         if ($ce->getOwner() == $owner)
            $list[] = $ce;
      }
      return $list;
   }

   public function init() {

      $this->table = array();
      for ($i = $this->startHour; $i < $this->endHour; $i++) {
         $temp = array();
         for ($j = 0; $j < 60; $j = $j + $this->delatMinute) {
            $temp[$j] = array();
         }
         $this->table[$i] = $temp;
      }
   }

   public function getHourAndCaseMinuteFromCalendarElement(CalendarElement $calendarElement) {
      $date = $calendarElement->getStartDate();
      $hour = $date->format('H');

      $hour = intval($hour);
      $minute = $date->format('i');
      $caseMinute;

      if ($minute >= 40 && $minute < 60) {
         $caseMinute = 40;
      } else if ($minute >= 20 && $minute < 40) {
         $caseMinute = 20;
      } else {
         $caseMinute = 0;
      }

      return array($hour, $caseMinute);
   }

   public function addCalendarElement(CalendarElement $calendarElement) {
      $test = in_array($calendarElement->getOwner(), $this->listOfOwners);
      if (!$test) {
         $this->listOfOwners[] = $calendarElement->getOwner();
         $this->listOfOdometerCellDelegate[$calendarElement->getOwner()->getId()] =
                 new OdometerCellDelegate($calendarElement->getOwner(), $this);
      }

      $this->listOfCalendarElement[] = $calendarElement;
      $this->listOfOdometerCellDelegate[$calendarElement->getOwner()->getId()]
              ->updateWith($calendarElement);



      list($hour, $caseMinute) = $this->getHourAndCaseMinuteFromCalendarElement($calendarElement);
      $this->table[$hour][$caseMinute][] = $calendarElement;
   }

   public function renderCalendarElement(CalendarElement $element) {
      $color = $element->getCSSClassForColor();
      $start = $element->getStartDate();
      $end = $element->getEndDate();
      $diff = $start->diff($end);
      $diffEnMinutes = $diff->i + (60 * $diff->h);
      $marginTop = -11;
      $marginTop += $element->getStartDate()->format('i') % $this->delatMinute;
      $element->configure();
      $title = $element->getTitle();
      $url = $this->controller->generateUrlForGettinfElementInfoAjax($element->getId());

      $html = '<a class="element ' . $color . '" href="#"    data-ajax="' . $url . '" 
         data-zipcode="km/'.$element->getZipCode().'"
            style="position: absolute; height:' . $diffEnMinutes . 'px;
               margin-top: ' . $marginTop . 'px"><span>
                  ' . $title . '<br>' .
              $start->format('H:i') . ' to ' . $end->format("H:i") . '
              </span></a>';
      return $html;
   }

   public function render() {


      $ownerCount = count($this->listOfOwners);
      $html = '';
      $html .= '<table class = "table table-striped table-bordered" id = "calendar" style = "">';
      $html .= '<thead>';
      $html .= '<tr>';
      $html .= '<td class = "hour">Hours</td>';
      $html .= '<td class = "minute">Minutes</td>';
      foreach ($this->listOfOwners as $owner) {
         $html .= '<td>' . $owner->getCalendarHeader() . '</td>';
      }

      $html .= '</tr>';
      $html .= '</thead>';
      $html .= '<tbody >';


      for ($i = $this->startHour; $i < $this->endHour; $i++) {
         $temp = array();
         for ($j = 0; $j < 60; $j = $j + $this->delatMinute) {
            $temp[$j] = array();
            $html .= '<tr>';
            if ($j == 0) {
               $html .= '<td rowspan = "3" class = "hour">' . $i . 'h</td>';
            }
            $html .= '<td class = "minute">' . $j . ' min</td>';

            foreach ($this->listOfOwners as $owner) {
               $cellId = $i.'-'.$j.'-'.$owner->getId();
               $html .= '<td data-cell-id="'.$cellId.'" data-column-id="' . $owner->getId() . '">';
               $html .= '<span class="km">';
               //$html .= $this->getOdometerCellDelegate($owner)
               //        ->getDistanceAt($i, $j);
               $html .= '</span>';

               foreach ($this->table[$i][$j] as $element) {
                  /* @var $element CalendarElement */
                  if ($element->getOwner() != $owner)
                     continue;
                  $html .= $this->renderCalendarElement($element);
               }

               $html .= '</td>
      ';
            }

            $html .= '</tr>
      ';
         }
      }


      $html .= '</tbody >
      ';
      $html .= '</table >
      ';

      return $html;
   }

   public function getOdometerCellDelegate($owner) {
      return $this->listOfOdometerCellDelegate[$owner->getId()];
   }

   public function getTable() {
      return $this->table;
   }

   public function setTable($table) {
      $this->table = $table;
   }

   public function getListOfOwners() {
      return $this->listOfOwners;
   }

   public function setListOfOwners($listOfOwners) {
      $this->listOfOwners = $listOfOwners;
   }

   public function getListOfCalendarElement() {
      return $this->listOfCalendarElement;
   }

   public function setListOfCalendarElement($listOfCalendarElement) {
      $this->listOfCalendarElement = $listOfCalendarElement;
   }

   public function getStartHour() {
      return $this->startHour;
   }

   public function setStartHour($startHour) {
      $this->startHour = $startHour;
   }

   public function getEndHour() {
      return $this->endHour;
   }

   public function setEndHour($endHour) {
      $this->endHour = $endHour;
   }

   public function getController() {
      return $this->controller;
   }

   public function setController($controller) {
      $this->controller = $controller;
   }

}

?>
