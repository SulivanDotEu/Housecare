<?php

namespace Housecare\WorkersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Housecare\CalendarBundle\Entity\CalendarElementOwnerInterface;
use Housecare\CalendarBundle\Entity\CalendarElement;

/**
 * Worker
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Housecare\WorkersBundle\Entity\WorkerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Worker implements CalendarElementOwnerInterface
{
   
   public function getFullName(){
      return $this->getFirstName().' '.$this->getLastName();
   }
   
   public function configureCalendarElement(CalendarElement $calendarElement){
      $calendarElement->setTitle($this->getFirstName()." ".$this->getLastName());
   }
   
   public function getCalendarHeader(){
      return $this->getFirstName()." ".$this->getLastName();
   }
   
   
   
   public static $listOfQualif = array(
       '1' => 'Plombier',
       '2' => 'Chauffage',
       '3' => 'Debouchage',
       '4' => 'Electricien',
       '5' => 'Vitrier',
       '6' => 'Serrurier',
       '7' => 'Autre',
   );
   
   public static $statut_free = 1;
   
   public static $listOfStatut = array(
       '1' => 'Free',
       '2' => 'Busy',
       '3' => 'Done',
       );


   public function isFree(){
      if($this->getStatut() == self::$listOfStatut[1])
         return true;
      return false;
   }
   public function isBusy(){
      if($this->getStatut() == self::$listOfStatut[2])
         return true;
      return false;
   }
   public function isDone(){
      if($this->getStatut() == self::$listOfStatut[3])
         return true;
      return false;
   }
   
   /**
    * @ORM\PostLoad
    */
   public function postLoad() {
      if (isset(self::$listOfQualif[$this->getQualification()]))
         $this->setQualification(self::$listOfQualif[$this->getQualification()]);
      if (isset(self::$listOfStatut[$this->getStatut()]))
         $this->setStatut(self::$listOfStatut[$this->getStatut()]);

      
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="smallint")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text")
     */
    private $note;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="smallint")
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=255)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="smallint")
     */
    private $qualification;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Worker
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Worker
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Worker
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Worker
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Worker
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Worker
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Worker
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Worker
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    
        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set qualification
     *
     * @param integer $qualification
     * @return Worker
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;
    
        return $this;
    }

    /**
     * Get qualification
     *
     * @return integer 
     */
    public function getQualification()
    {
        return $this->qualification;
    }
}