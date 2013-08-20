<?php

namespace Housecare\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Housecare\CostumersBundle\Entity\Costumers;
use Housecare\WorkersBundle\Entity\Worker;
use Housecare\CalendarBundle\Entity\CalendarElement;
use Housecare\CalendarBundle\Entity\CalendarElementDelegateInterface;

/**
 * Job
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Housecare\JobBundle\Entity\JobRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Job implements CalendarElementDelegateInterface{
   
   public function configureCalendarElement(CalendarElement $calendarElement){
      if($this->getCostumers() != null){
         $calendarElement->setTitle($this->getCostumers()->getFirstName().
                 ' '.$this->getCostumers()->getLastName());
         $calendarElement->setZipCode($this->getCostumers()->getZipCode());
         return;
         
      }
      $calendarElement->setTitle("Job #".$this->getId());
   }
   
   public function getCalendarHeader(){
      return "Job->getCalendarHeader()";
   }
   
   

   public static $listOfTypes = array(
       '1' => 'Plombier',
       '2' => 'Chauffage',
       '3' => 'Debouchage',
       '4' => 'Electricien',
       '5' => 'Vitrier',
       '6' => 'Serrurier',
       '7' => 'Autre',
   );
   public static $listOfSubtypes = array(
       '1' => 'Intervention',
       '2' => 'Devis Payant',
       '3' => 'Devis Gratuit');
   public static $listOfTimeNeeded = array(
       '1' => '20 min',
       '2' => '40 min',
       '3' => '1 hour',
       '4' => '1 hour 20',
       '5' => '1 hour 40',
       '6' => '2 hour',
       '7' => '2 hour 20',
       '8' => '2 hour 40',
       '9' => '3 hour',
       '10' => '4 hour',
       '11' => '5 hour',
       '12' => '6 hour',
       '13' => '7 hour',
       '14' => '1 Day',
       '15' => '2 Day',
       '16' => '3 Day',
       '17' => '4 Day',
       '18' => '5 Day',
       '19' => '8 Day',
       '20' => '16 Day',
   );
   public static $listOfThanksTo = array(
       '1' => '01 : Google',
       '2' => '02 : web gratuit',
       '3' => '03 : QueFaire',
       '4' => '04 : Vivastreet',
       '5' => '05 : page Google+maps',
       '6' => '06 : sites SEO Alex',
       '7' => '07 : Camionnette + polos',
       '8' => '08 : Magnets',
       '9' => '09 : ',
       '10' => '10 : ',
       '11' => '11 : ',
       '12' => '12 : BlueBook sol 1',
       '13' => '13 : ',
       '14' => '14 : ',
       '15' => '15 : ',
       '16' => '16 : ',
       '17' => '17 : ',
       '18' => '18 : ',
       '19Reach locals' => '19 : Reach locals',
       '20' => '20 : ',
       '21' => 'Pages d or',
       '22' => 'IMMO Univ. Anthony',
       '23' => 'Vlan',
       '24' => 'Skilto',
       '25' => '2deHands',
       '26' => 'Kapaza',
       '27' => 'Hebbes',
       '28' => 'Aanbod',
       '29' => 'BouwInfo',
       '30' => 'Passe Partout',
       '31' => 'Kooples krant',
       '32' => 'Seniorennet',
       '33' => 'Ami',
       '34' => 'Client existant',
       '35' => 'Autre..',
   );

   function __construct() {
      $this->setCreationDate(new \DateTime());
   }
   
   public function isAssignedToWorker(){
      if($this->getWorker() == null) return false;
      return true;
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
    * @var string
    *
    * @ORM\Column(name="description", type="text")
    */
   private $description;

   /**
    * @var string
    *
    * @ORM\Column(name="type", type="string", length=255)
    */
   private $type;

   /**
    * @var string
    *
    * @ORM\Column(name="subtype", type="string", length=255)
    */
   private $subtype;

   /**
    * @var string
    *
    * @ORM\Column(name="timeNeeded", type="string", length=255)
    */
   private $timeNeeded;

   /**
    * @var string
    *
    * @ORM\Column(name="thanksTo", type="string", length=255)
    */
   private $thanksTo;

   /**
    * @var \DateTime
    *
    * @ORM\Column(name="creationDate", type="datetime", nullable = false)
    */
   private $creationDate;

   /**
    * @var \DateTime
    *
    * @ORM\Column(name="updateDate", type="datetime", nullable = true)
    */
   private $updateDate;

   /**
    * @var \Housecare\CostumersBundle\Entity\Costumers
    * 
    * @ORM\OneToOne(targetEntity="\Housecare\CostumersBundle\Entity\Costumers", cascade={"persist"})
    */
   private $costumers;
   
   /**
    * @var Housecare\WorkersBundle\Entity\Worker
    * 
    * @ORM\ManyToOne(targetEntity="Housecare\WorkersBundle\Entity\Worker", cascade={"persist"})
    */
   private $worker;
   
   /**
    * @var Housecare\CalendarBundle\Entity\CalendarElement
    * 
    * @ORM\OneToOne(targetEntity="Housecare\CalendarBundle\Entity\CalendarElement", cascade={"persist"})
    */
   private $calendarElement;

   /**
    * Get id
    *
    * @return integer 
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set description
    *
    * @param string $description
    * @return Job
    */
   public function setDescription($description) {
      $this->description = $description;

      return $this;
   }

   /**
    * Get description
    *
    * @return string 
    */
   public function getDescription() {
      return $this->description;
   }

   /**
    * Set type
    *
    * @param string $type
    * @return Job
    */
   public function setType($type) {
      $this->type = $type;

      return $this;
   }

   /**
    * Get type
    *
    * @return string 
    */
   public function getType() {
      return $this->type;
   }

   /**
    * Set subtype
    *
    * @param string $subtype
    * @return Job
    */
   public function setSubtype($subtype) {
      $this->subtype = $subtype;

      return $this;
   }

   /**
    * Get subtype
    *
    * @return string 
    */
   public function getSubtype() {
      return $this->subtype;
   }

   /**
    * Set timeNeeded
    *
    * @param string $timeNeeded
    * @return Job
    */
   public function setTimeNeeded($timeNeeded) {
      $this->timeNeeded = $timeNeeded;

      return $this;
   }

   /**
    * Get timeNeeded
    *
    * @return string 
    */
   public function getTimeNeeded() {
      return $this->timeNeeded;
   }

   /**
    * Set thanksTo
    *
    * @param string $thanksTo
    * @return Job
    */
   public function setThanksTo($thanksTo) {
      $this->thanksTo = $thanksTo;

      return $this;
   }

   /**
    * Get thanksTo
    *
    * @return string 
    */
   public function getThanksTo() {
      return $this->thanksTo;
   }

   /**
    * Set creationDate
    *
    * @param \DateTime $creationDate
    * @return Job
    */
   public function setCreationDate($creationDate) {
      $this->creationDate = $creationDate;

      return $this;
   }

   /**
    * Get creationDate
    *
    * @return \DateTime 
    */
   public function getCreationDate() {
      return $this->creationDate;
   }

   /**
    * Set updateDate
    *
    * @param \DateTime $updateDate
    * @return Job
    */
   public function setUpdateDate($updateDate) {
      $this->updateDate = $updateDate;

      return $this;
   }

   /**
    * Get updateDate
    *
    * @return \DateTime 
    */
   public function getUpdateDate() {
      return $this->updateDate;
   }

   /**
    * @ORM\PostLoad
    */
   public function postLoad() {
      if (isset(self::$listOfSubtypes[$this->subtype]))
         $this->setSubtype(self::$listOfSubtypes[$this->subtype]);

      if (isset(self::$listOfTypes[$this->type]))
         $this->setType(self::$listOfTypes[$this->type]);

      if (isset(self::$listOfThanksTo[$this->thanksTo]))
         $this->setThanksTo(self::$listOfThanksTo[$this->thanksTo]);

      if (isset(self::$listOfTimeNeeded[$this->timeNeeded]))
         $this->setTimeNeeded(self::$listOfTimeNeeded[$this->timeNeeded]);
   }

   /**
    * Set costumers
    *
    * @param \Housecare\CostumersBundle\Entity\Costumers $costumers
    * @return Job
    */
   public function setCostumers(\Housecare\CostumersBundle\Entity\Costumers $costumers = null) {
      $this->costumers = $costumers;

      return $this;
   }

   /**
    * Get costumers
    *
    * @return \Housecare\CostumersBundle\Entity\Costumers 
    */
   public function getCostumers() {
      return $this->costumers;
   }

   
   public function hasCostumers() {
      if($this->getCostumers() == null){
         return false;
      }
      return true;
   }
   
   public function isSchedule() {
      if($this->getCalendarElement() == null){
         return false;
      }
      return true;
   }


    /**
     * Set worker
     *
     * @param \Housecare\WorkerBundle\Entity\Worker $worker
     * @return Job
     */
    public function setWorker(\Housecare\WorkersBundle\Entity\Worker $worker = null)
    {
        $this->worker = $worker;
    
        return $this;
    }

    /**
     * Get worker
     *
     * @return \Housecare\WorkerBundle\Entity\Worker 
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * Set calendarElement
     *
     * @param string $calendarElement
     * @return Job
     */
    public function setCalendarElement($calendarElement)
    {
        $this->calendarElement = $calendarElement;
    
        return $this;
    }

    /**
     * Get calendarElement
     *
     * @return CalendarElement 
     */
    public function getCalendarElement()
    {
        return $this->calendarElement;
    }
}