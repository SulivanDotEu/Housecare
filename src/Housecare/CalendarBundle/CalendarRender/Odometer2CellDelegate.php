<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OdometerCellDelegate
 *
 * @author Teta
 */
use \DateTime;
use \Symfony\Component\Validator\Exception\InvalidArgumentException;
use Housecare\CalendarBundle\CalendarRender\CalendarRenderCellDelegateInterface;
use Housecare\CalendarBundle\CalendarRender\CalendarRender;
use Housecare\CalendarBundle\Entity\CalendarElement;

namespace Housecare\CalendarBundle\CalendarRender;

class OdometerCellDelegate implements CalendarRenderCellDelegateInterface {

   //put your code here

   public $owner;             //
   public $calendarRender;    //
   public $defaultZipCode;    //
   public $deltaCase = null;  //
   public $speed = 90;        //
   public $deltaMinute = 20;
   public $zipCodeToCompare = 6600;
   public $startHour;
   public $endHour;
   public $cases;

   function __construct($owner, CalendarRender $cr) {
      $this->setOwner($owner);
      $this->prepare($cr);
   }

   public function prepare(CalendarRender $cr) {
      $this->setCalendarRender($cr);
      $this->setDeltaMinute($cr->getDelatMinute());
      $defaultDistance = $this->distance($this->defaultZipCode, $this->zipCodeToCompare);
      $this->setStartHour($cr->getStartHour());
      $this->setEndHour($cr->getEndHour());

      $this->cases = array();
      for ($i = $this->getStartHour(); $i < $this->getEndHour(); $i++) {
         $temp = array();
         for ($j = 0; $j < 60; $j = $j + $this->getDeltaMinute()) {
            $temp[$j] = $defaultDistance;
         }
         $this->cases[$i] = $temp;
      }
      return $this;
   }

   public function setUpNewDistance($hour, $caseMinute, $newDistance) {
      $this->updateDistanceAt($hour, $caseMinute, $newDistance);
      $minute = $caseMinute + $this->deltaMinute;
      if ($minute >= 60) {
         $minute = 0;
         $hour++;
      }
      if ($this->updateDistanceAt($hour, $minute, $newDistance))
         $this->setUpNewDistance($hour, $minute, $newDistance);
   }

   public function updateWith(\Housecare\CalendarBundle\Entity\CalendarElement $ce) {
      list($hour, $caseMinute) = $this->getCalendarRender()
              ->getHourAndCaseMinuteFromCalendarElement($ce);
      $ceZipCode = $ce->getZipCode();
      $oldDistance = $this->getDistanceAt($hour, $caseMinute);
      $newDistance = $this->distance($ceZipCode, $this->zipCodeToCompare);
      if ($oldDistance == $newDistance)
         return;
      $this->setUpNewDistance($hour, $caseMinute, $newDistance);
      $minutes = $newDistance / $this->getSpeed() * 60;
      $caseCount = $minutes / $this->getDeltaMinute();
      $diff = $newDistance / $caseCount;

      $plusOrMinus = $oldDistance > $newDistance;
      $this->updateDistance($hour, $caseMinute, $diff, $plusOrMinus);
   }

   /**
    * 
    * @param type $hour
    * @param type $caseMinute
    * @param type $diff
    * @param boolean $plusOrMinus -> represente la formule mathematique a appliquer
    *    sur la valeur actuelle du tableau
    *    true = plus
    *    false = minus
    */
   public function updateDistance($hour, $minute, $diff, $plusOrMinus) {
      // on récupere la distance actuelle
      $oldDistance = $this->getDistanceAt($hour, $minute);
      // d'abord on se positionne
      $minute = $minute - $this->deltaMinute;
      if ($minute < 0) {
         $minute = 60 - $this->deltaMinute;
         $hour--;
      }

      $hour2 = $hour;
      $minute2 = $minute - $this->deltaMinute;
      if ($minute2 < 0) {
         $minute2 = 60 - $this->deltaMinute;
         $hour2--;
      }


      $nextChange = $this->getDistanceAt($hour2, $minute2);

      // puis je retire ou j'ajoute
      if ($plusOrMinus) {
         $newDistance = $oldDistance + $diff;
         if ($nextChange < $newDistance)
            return;

         $result = $this->updateDistanceAt($hour, $minute, $newDistance);
      } else {
         $newDistance = $oldDistance - $diff;

         if ($nextChange > $newDistance)
            return;
         $result = $this->updateDistanceAt($hour, $minute, $newDistance);
      }
      if ($result == null)
         return;
      $this->updateDistance($hour, $minute, $diff, $plusOrMinus);

      // keep going tant qu'il le faut
   }

   public function getOwner() {
      return $this->owner;
   }

   public function setOwner($owner) {
      $this->owner = $owner;
      $this->defaultZipCode = $owner->getZipCode();
   }

   public function distance($zipCode1, $zipCode2) {
      if ($zipCode1 == 6000 AND $zipCode2 == 6600)
         return 90;
      if ($zipCode1 == 1000 AND $zipCode2 == 6600)
         return 180;
      return 270;
   }

   public function getDeltaCase() {
      if ($this->deltaCase == null) {
         $this->deltaCase = 60 / $this->deltaMinute;
      }
      return $this->deltaCase;
   }

   public function setDeltaMinute($deltaMinute) {
      if ($this->deltaMinute == null
              OR $this->deltaMinute < 0
              OR $this->deltaMinute > 59
              OR (60 % $this->deltaMinute != 0))
         throw new InvalidArgumentException("Dela Minute is not correct");
      $this->deltaMinute = $deltaMinute;
   }

   public function getDistanceAt($hour, $minute) {
      if (!isset($this->cases[$hour][$minute])) {
         return null;
      }
      return $this->cases[$hour][$minute];
   }

   /**
    * 
    * @param type $hour
    * @param type $minute
    * @param type $newsDistance
    * @return int
    *       quand true, on continue de bouger
    *       quand false, on stop
    */
   public function updateDistanceAt($hour, $minute, $newsDistance) {
      if (!isset($this->cases[$hour][$minute])) {
         return null;
      }
      $this->cases[$hour][$minute] = ceil($newsDistance);
      return true;
   }

   /** GETTER SETTER */
   public function getDeltaMinute() {
      return $this->deltaMinute;
   }

   public function getCalendarRender() {
      return $this->calendarRender;
   }

   public function setCalendarRender($calendarRender) {
      $this->calendarRender = $calendarRender;
   }

   public function getDefaultZipCode() {
      return $this->defaultZipCode;
   }

   public function setDefaultZipCode($defaultZipCode) {
      $this->defaultZipCode = $defaultZipCode;
   }

   public function getSpeed() {
      return $this->speed;
   }

   public function setSpeed($speed) {
      $this->speed = $speed;
   }

   public function getZipCodeToCompare() {
      return $this->zipCodeToCompare;
   }

   public function setZipCodeToCompare($zipCodeToCompare) {
      $this->zipCodeToCompare = $zipCodeToCompare;
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

   public function getCases() {
      return $this->cases;
   }

   public function setCases($cases) {
      $this->cases = $cases;
   }

}

?>
