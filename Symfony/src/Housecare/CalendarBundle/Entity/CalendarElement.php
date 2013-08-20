<?php

namespace Housecare\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Housecare\CalendarBundle\Entity\DefaultOwner;

/**
 * CalendarElement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Housecare\CalendarBundle\Entity\CalendarElementRepository")
 */
class CalendarElement {
   
    /**
    * @ORM\PostLoad
    */
   public function postLoad() {
      if (isset(self::$LIST_OF_COLOR[$this->getColor()]))
         $this->setColor(self::$LIST_OF_COLOR[$this->getColor()]);
      
   }
   
   public function configure(){
      $this->delegate->configureCalendarElement($this);
   }

   /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   private $id;

   /**
    * @var \DateTime
    *
    * @ORM\Column(name="startDate", type="datetime")
    */
   private $startDate;

   /**
    * @var \DateTime
    *
    * @ORM\Column(name="endDate", type="datetime")
    */
   private $endDate;

   /**
    * @var string
    *
    * @ORM\Column(name="color", type="string", length=255)
    */
   private $color = 7;
   
   /**
    *
    * @var CalendarElementOwnerInterface
    */
   private $owner;
   private $delegate;
   private $title = "undefined";
   private $zipCode = 1000;
   
   
   
   public static $COLOR_RED = 1;
   public static $COLOR_GREEN = 2;
   public static $COLOR_YELLOW = 3;
   public static $COLOR_ORANGE = 4;
   public static $COLOR_WHITE = 5;
   public static $COLOR_BLUE = 6;
   public static $COLOR_CYAN = 7;
   public static $COLOR_BLACK = 8;
   
   
   public static $LIST_OF_COLOR = array(
       1 => 'Red',
       2 => 'Green',
       3 => 'Yellow',
       4 => 'Orange',
       5 => 'White',
       6 => 'Blue',
       7 => 'Cyan',
       8 => 'Black',
   );
   
   function __construct() {
       $this->setStartDate(new \DateTime());
       $this->setEndDate(new \DateTime());
       $this->setOwner(DefaultOwner::getInstance());
    }
    
    public function getCSSClassForColor(){
       switch ($this->getColor()) {
          case self::$COLOR_GREEN:
             return 'green';
             break;
          case self::$COLOR_CYAN:
             return 'cyan';
             break;
          case self::$COLOR_RED:
             return 'red';
             break;
          case self::$COLOR_YELLOW:
             return 'yellow';
             break;
          case self::$COLOR_WHITE:
             return 'white';
             break;
          case self::$COLOR_ORANGE:
             return 'orange';
             break;
          case self::$COLOR_BLACK:
             return 'black';
             break;

          default:
             return 'cyan';
             break;
       }
    }
   
    public function getZipCode() {
       return $this->zipCode;
    }

    public function setZipCode($zipCode) {
       $this->zipCode = $zipCode;
    }

        
    
   public function getTitle() {
      return $this->title;
   }

   public function setTitle($title) {
      $this->title = $title;
   }

   public function getDelegate() {
      return $this->delegate;
   }

   public function setDelegate($delegate) {
      $this->delegate = $delegate;
      return $this;
   }

   public function getOwner() {
      return $this->owner;
   }

   public function setOwner($owner) {
      $this->owner = $owner;
      
      
      return $this;
   }

   /**
    * Get id
    *
    * @return integer 
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set startDate
    *
    * @param \DateTime $startDate
    * @return CalendarElement
    */
   public function setStartDate($startDate) {
      $this->startDate = $startDate;

      return $this;
   }

   /**
    * Get startDate
    *
    * @return \DateTime 
    */
   public function getStartDate() {
      return $this->startDate;
   }

   /**
    * Set endDate
    *
    * @param \DateTime $endDate
    * @return CalendarElement
    */
   public function setEndDate($endDate) {
      $this->endDate = $endDate;

      return $this;
   }

   /**
    * Get endDate
    *
    * @return \DateTime 
    */
   public function getEndDate() {
      return $this->endDate;
   }

   /**
    * Set color
    *
    * @param string $color
    * @return CalendarElement
    */
   public function setColor($color) {
      $this->color = $color;

      return $this;
   }

   /**
    * Get color
    *
    * @return string 
    */
   public function getColor() {
      return $this->color;
   }

}