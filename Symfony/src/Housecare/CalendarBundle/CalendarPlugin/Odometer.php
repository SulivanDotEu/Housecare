<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Odometer
 *
 * @author Teta
 */

namespace Housecare\CalendarBundle\CalendarPlugin;

use Housecare\CalendarBundle\Entity\CalendarElement;

class Odometer {

   //put your code here
   public $listOwner;
   public $repositoryCoordscp;
   public $startHour;
   public $endHour;
   public $deltaMinute = 20;
   public $baseTable;
   public $listElement;
   public $resultsTable;
   public $zipCode;
   
   public $_logger;

   function __construct($repositoryCoordscp, $startHour, $endHour, $zipCode, $logger) {
      $this->listOwner = array();
      $this->listElement = array();
      $this->repositoryCoordscp = $repositoryCoordscp;
      $this->startHour = $startHour;
      $this->endHour = $endHour;
      $this->buildBaseTable();
      $this->zipCode = $zipCode;
      $this->_logger = $logger;
   }

   public function setZipCodeForOwnerAtIndex($zipCode, $owner, $index) {
      list($lat, $long) = $this->getCoord($zipCode);
      $this->resultsTable[$owner->getId()][$index]['lat'] = $lat;
      $this->resultsTable[$owner->getId()][$index]['long'] = $long;
   }

   public function setCoordForOwnerAtIndex($lat, $long, $owner, $index) {
      $this->resultsTable[$owner->getId()][$index]['lat'] = $lat;
      $this->resultsTable[$owner->getId()][$index]['long'] = $long;
   }

   public function getCoordForOwnerAtIndex($owner, $index) {
      return $this->resultsTable[$owner->getId()][$index];
   }

   public function getTableOfKm() {
      $this->resultsTable = array();
      foreach ($this->listOwner as $id => $owner) {
         /* @var $owner \Housecare\WorkersBundle\Entity\Worker */
         $this->resultsTable[$id] = $this->baseTable;
         $this->setZipCodeForOwnerAtIndex(
                 $owner->getZipCode(), $owner, 0);
         $this->setZipCodeForOwnerAtIndex(
                 $owner->getZipCode(), $owner, count($this->resultsTable[$id]) - 1);
         foreach ($this->listElement[$id] as $element) {
            $this->_logger->info('mise en place de l\'element : '.$element->getId());
            $this->_logger->info('element#'.$element->getId()."->getZipCode() => ".$element->getZipCode());
            $this->_logger->info('element#'.$element->getId()."->getDelegate() => ".$element->getDelegate()->getId());
            /* @var $element CalendarElement */
            $index = $this->getIndiceByDateTime($element->getStartDate());
            $bound = $this->getIndiceByDateTime($element->getEndDate());
            for (; $index <= $bound; $index++) {
               $this->setZipCodeForOwnerAtIndex(
                       $element->getZipCode(), $owner, $index);
            }
         }
         // on remplis les trou maintenant
         $this->fillTempResultTable($owner);
      }

      $coordRef = $this->getCoord($this->zipCode);
      //var_dump($coordRef);
      $table = array();
      foreach ($this->listOwner as $id => $owner) {
         $index = 0;
         for ($i = $this->startHour; $i < $this->endHour; $i++) {
            for ($j = 0; $j < 60; $j = $j + $this->deltaMinute) {
               $coord = $this->getCoordForOwnerAtIndex($owner, $index);
               $table[$i . '-' . $j . '-' . $id] = $this->getDistance($coord['lat'], $coord['long'], $coordRef[0], $coordRef[1]);
               $index++;
            }
         }
      }
      return $table;
   }

   function getDistance($lat1, $lng1, $lat2, $lng2) {
      $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
      $rlo1 = deg2rad($lng1);
      $rla1 = deg2rad($lat1);
      $rlo2 = deg2rad($lng2);
      $rla2 = deg2rad($lat2);
      $dlo = ($rlo2 - $rlo1) / 2;
      $dla = ($rla2 - $rla1) / 2;
      $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo
              ));
      $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
      $temp =  ($earth_radius * $d) / 1000;
      return round($temp);
   }

   public function fillTempResultTable($owner) {
      $currentIndex = 0;
      $nextIndex = $currentIndex + 1;
      $maxIndex = count($this->resultsTable[$owner->getId()]);

      while ($nextIndex < $maxIndex) {



         while ($this->resultsTable[$owner->getId()][$nextIndex]['long'] == null) {
            $nextIndex++;
         }

         $a = $this->getCoordForOwnerAtIndex($owner, $currentIndex);
         $b = $this->getCoordForOwnerAtIndex($owner, $nextIndex);


         for ($tempIndex = ($currentIndex + 1); $tempIndex < $nextIndex; $tempIndex++) {

            $lat = $this->equationLineaire($currentIndex, $a['lat'], $nextIndex, $b['lat'], $tempIndex);
            $long = $this->equationLineaire($currentIndex, $a['long'], $nextIndex, $b['long'], $tempIndex);
            //var_dump("c[" . $tempIndex . "] => [" . $lat . ", " . $long . "]");
            $this->setCoordForOwnerAtIndex($lat, $long, $owner, $tempIndex);
         }
         $currentIndex = $nextIndex;
         $nextIndex = $currentIndex + 1;
      }
   }

   function equationLineaire($x1, $y1, $x2, $y2, $x3) {

      $m = ($y2 - $y1) / ($x2 - $x1);
      $p = $y1 - ($m * $x1);
      $y3 = ($m * $x3) + $p;
      return $y3;
   }

   public function getIndiceByDateTime(\DateTime $date) {
      $hour = $date->format('H');
      $hour = intval($hour);
      $minute = $date->format('i');

      $index = ($hour - $this->startHour) * 3 + (floor($minute / 20));
      //var_dump($hour . "h" . $minute . " -> index : " . $index);
      return $index;
   }

   public function getCoord($zipCode) {
      static $listZC = array();
      if (!isset($listZC[$zipCode])) {
         $listZC[$zipCode] = $this->repositoryCoordscp->findByZip($zipCode)[0];
      }

      $coord = $listZC[$zipCode];
      /* @var $coord \Housecare\CalendarBundle\Entity\Coordscp */
      return [$coord->getLat(), $coord->getLng()];
   }

   public function buildBaseTable() {
      $this->baseTable = array();
      $index = 0;
      for ($i = $this->startHour; $i < $this->endHour; $i++) {
         for ($j = 0; $j < 60; $j = $j + $this->deltaMinute) {
            $this->baseTable[$index] = array();
            $this->baseTable[$index]['lat'] = null;
            $this->baseTable[$index]['long'] = null;
            $index++;
         }
      }
   }

   public function addCalendarElements($array) {
      foreach ($array as $element) {
         $this->addCalendarElement($element);
      }
   }

   public function addCalendarElement(CalendarElement $calendarElement) {
      $owner = $calendarElement->getOwner();
      $test = in_array($owner, $this->listOwner);
      if (!$test) {
         $this->listOwner[$owner->getId()] = $owner;
      }
      $this->listElement[$owner->getId()][] = $calendarElement;
      $calendarElement->configure();
   }

}

?>
