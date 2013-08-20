<?php

namespace Housecare\WorkersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Housecare\WorkersBundle\Entity\PersonRepository")
 */
class Person {

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
    * @ORM\Column(name="phone", type="string", length=50)
    */
   private $phone;

   /**
    * @ORM\OneToOne(targetEntity="Housecare\WorkersBundle\Entity\Address", cascade={"persist"})
    */
   private $address;

   /**
    * Get id
    *
    * @return integer 
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set firstName
    *
    * @param string $firstName
    * @return Person
    */
   public function setFirstName($firstName) {
      $this->firstName = $firstName;

      return $this;
   }

   /**
    * Get firstName
    *
    * @return string 
    */
   public function getFirstName() {
      return $this->firstName;
   }

   /**
    * Set lastName
    *
    * @param string $lastName
    * @return Person
    */
   public function setLastName($lastName) {
      $this->lastName = $lastName;

      return $this;
   }

   /**
    * Get lastName
    *
    * @return string 
    */
   public function getLastName() {
      return $this->lastName;
   }

   /**
    * Set phone
    *
    * @param string $phone
    * @return Person
    */
   public function setPhone($phone) {
      $this->phone = $phone;

      return $this;
   }

   /**
    * Get phone
    *
    * @return string 
    */
   public function getPhone() {
      return $this->phone;
   }


    /**
     * Set address
     *
     * @param \Housecare\WorkersBundle\Entity\Address $address
     * @return Person
     */
    public function setAddress(\Housecare\WorkersBundle\Entity\Address $address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \Housecare\WorkersBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }
}