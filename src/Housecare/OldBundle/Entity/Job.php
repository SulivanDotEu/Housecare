<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity
 */
class Job
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="subtype", type="string", length=255, nullable=false)
     */
    private $subtype;

    /**
     * @var string
     *
     * @ORM\Column(name="timeNeeded", type="string", length=255, nullable=false)
     */
    private $timeneeded;

    /**
     * @var string
     *
     * @ORM\Column(name="thanksTo", type="string", length=255, nullable=false)
     */
    private $thanksto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false)
     */
    private $creationdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime", nullable=true)
     */
    private $updatedate;

    /**
     * @var \Calendarelement
     *
     * @ORM\ManyToOne(targetEntity="Calendarelement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="calendarElement_id", referencedColumnName="id")
     * })
     */
    private $calendarelement;

    /**
     * @var \Costumers
     *
     * @ORM\ManyToOne(targetEntity="Costumers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="costumers_id", referencedColumnName="id")
     * })
     */
    private $costumers;

    /**
     * @var \Worker
     *
     * @ORM\ManyToOne(targetEntity="Worker")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="worker_id", referencedColumnName="id")
     * })
     */
    private $worker;


}
