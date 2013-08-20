<?php

namespace Housecare\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordscp
 *
 * @ORM\Table(name="coordscp")
 * @ORM\Entity
 */
class Coordscp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=2, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="Language", type="string", length=2, nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="ISO2", type="string", length=6, nullable=false)
     */
    private $iso2;

    /**
     * @var string
     *
     * @ORM\Column(name="Region1", type="string", length=60, nullable=false)
     */
    private $region1;

    /**
     * @var string
     *
     * @ORM\Column(name="Region2", type="string", length=60, nullable=false)
     */
    private $region2;

    /**
     * @var string
     *
     * @ORM\Column(name="Region3", type="string", length=60, nullable=false)
     */
    private $region3;

    /**
     * @var string
     *
     * @ORM\Column(name="Region4", type="string", length=60, nullable=false)
     */
    private $region4;

    /**
     * @var string
     *
     * @ORM\Column(name="ZIP", type="string", length=10, nullable=false)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=60, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="Area1", type="string", length=80, nullable=false)
     */
    private $area1;

    /**
     * @var string
     *
     * @ORM\Column(name="Area2", type="string", length=80, nullable=false)
     */
    private $area2;

    /**
     * @var float
     *
     * @ORM\Column(name="Lat", type="float", nullable=false)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="Lng", type="float", nullable=false)
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="TZ", type="string", length=30, nullable=false)
     */
    private $tz;

    /**
     * @var string
     *
     * @ORM\Column(name="UTC", type="string", length=10, nullable=false)
     */
    private $utc;

    /**
     * @var string
     *
     * @ORM\Column(name="DST", type="string", length=1, nullable=false)
     */
    private $dst;



    /**
     * Set country
     *
     * @param string $country
     * @return Coordscp
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Coordscp
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set iso2
     *
     * @param string $iso2
     * @return Coordscp
     */
    public function setIso2($iso2)
    {
        $this->iso2 = $iso2;
    
        return $this;
    }

    /**
     * Get iso2
     *
     * @return string 
     */
    public function getIso2()
    {
        return $this->iso2;
    }

    /**
     * Set region1
     *
     * @param string $region1
     * @return Coordscp
     */
    public function setRegion1($region1)
    {
        $this->region1 = $region1;
    
        return $this;
    }

    /**
     * Get region1
     *
     * @return string 
     */
    public function getRegion1()
    {
        return $this->region1;
    }

    /**
     * Set region2
     *
     * @param string $region2
     * @return Coordscp
     */
    public function setRegion2($region2)
    {
        $this->region2 = $region2;
    
        return $this;
    }

    /**
     * Get region2
     *
     * @return string 
     */
    public function getRegion2()
    {
        return $this->region2;
    }

    /**
     * Set region3
     *
     * @param string $region3
     * @return Coordscp
     */
    public function setRegion3($region3)
    {
        $this->region3 = $region3;
    
        return $this;
    }

    /**
     * Get region3
     *
     * @return string 
     */
    public function getRegion3()
    {
        return $this->region3;
    }

    /**
     * Set region4
     *
     * @param string $region4
     * @return Coordscp
     */
    public function setRegion4($region4)
    {
        $this->region4 = $region4;
    
        return $this;
    }

    /**
     * Get region4
     *
     * @return string 
     */
    public function getRegion4()
    {
        return $this->region4;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Coordscp
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    
        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Coordscp
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set area1
     *
     * @param string $area1
     * @return Coordscp
     */
    public function setArea1($area1)
    {
        $this->area1 = $area1;
    
        return $this;
    }

    /**
     * Get area1
     *
     * @return string 
     */
    public function getArea1()
    {
        return $this->area1;
    }

    /**
     * Set area2
     *
     * @param string $area2
     * @return Coordscp
     */
    public function setArea2($area2)
    {
        $this->area2 = $area2;
    
        return $this;
    }

    /**
     * Get area2
     *
     * @return string 
     */
    public function getArea2()
    {
        return $this->area2;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Coordscp
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Coordscp
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    
        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set tz
     *
     * @param string $tz
     * @return Coordscp
     */
    public function setTz($tz)
    {
        $this->tz = $tz;
    
        return $this;
    }

    /**
     * Get tz
     *
     * @return string 
     */
    public function getTz()
    {
        return $this->tz;
    }

    /**
     * Set utc
     *
     * @param string $utc
     * @return Coordscp
     */
    public function setUtc($utc)
    {
        $this->utc = $utc;
    
        return $this;
    }

    /**
     * Get utc
     *
     * @return string 
     */
    public function getUtc()
    {
        return $this->utc;
    }

    /**
     * Set dst
     *
     * @param string $dst
     * @return Coordscp
     */
    public function setDst($dst)
    {
        $this->dst = $dst;
    
        return $this;
    }

    /**
     * Get dst
     *
     * @return string 
     */
    public function getDst()
    {
        return $this->dst;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}