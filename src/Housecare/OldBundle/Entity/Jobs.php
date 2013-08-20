<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity
 */
class Jobs
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjout", type="datetime", nullable=false)
     */
    private $dateajout;

    /**
     * @var integer
     *
     * @ORM\Column(name="customerId", type="integer", nullable=false)
     */
    private $customerid;

    /**
     * @var integer
     *
     * @ORM\Column(name="workerId", type="integer", nullable=false)
     */
    private $workerid;

    /**
     * @var string
     *
     * @ORM\Column(name="jobDesc", type="string", length=255, nullable=false)
     */
    private $jobdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="jobDesc2", type="string", length=100, nullable=false)
     */
    private $jobdesc2;

    /**
     * @var string
     *
     * @ORM\Column(name="jobType", type="string", length=20, nullable=false)
     */
    private $jobtype;

    /**
     * @var string
     *
     * @ORM\Column(name="jobSubType", type="string", length=20, nullable=false)
     */
    private $jobsubtype;

    /**
     * @var string
     *
     * @ORM\Column(name="timingChantier", type="string", length=20, nullable=false)
     */
    private $timingchantier;

    /**
     * @var integer
     *
     * @ORM\Column(name="estTime", type="integer", nullable=false)
     */
    private $esttime;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="paid", type="string", length=20, nullable=false)
     */
    private $paid;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=20, nullable=false)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=20, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="addPayment", type="string", length=20, nullable=false)
     */
    private $addpayment;

    /**
     * @var string
     *
     * @ORM\Column(name="vatIncluded", type="string", length=20, nullable=false)
     */
    private $vatincluded;

    /**
     * @var string
     *
     * @ORM\Column(name="toTheWorker", type="string", length=20, nullable=false)
     */
    private $totheworker;

    /**
     * @var string
     *
     * @ORM\Column(name="paidToWorker", type="string", length=20, nullable=false)
     */
    private $paidtoworker;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="meeting", type="datetime", nullable=false)
     */
    private $meeting;

    /**
     * @var string
     *
     * @ORM\Column(name="thanksTo", type="string", length=100, nullable=false)
     */
    private $thanksto;

    /**
     * @var integer
     *
     * @ORM\Column(name="smsSent", type="integer", nullable=false)
     */
    private $smssent;

    /**
     * @var integer
     *
     * @ORM\Column(name="viaLaurent", type="integer", nullable=false)
     */
    private $vialaurent;

    /**
     * @var integer
     *
     * @ORM\Column(name="sms_batch_id", type="integer", nullable=false)
     */
    private $smsBatchId;

    /**
     * @var integer
     *
     * @ORM\Column(name="sms_send_status", type="integer", nullable=false)
     */
    private $smsSendStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="sms_status", type="integer", nullable=false)
     */
    private $smsStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="modifiedAfterSms", type="integer", nullable=false)
     */
    private $modifiedaftersms;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStat", type="integer", nullable=false)
     */
    private $idstat;


}
