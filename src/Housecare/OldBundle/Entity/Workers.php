<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workers
 *
 * @ORM\Table(name="workers")
 * @ORM\Entity
 */
class Workers
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
     * @ORM\Column(name="firstName", type="string", length=30, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="gsm", type="string", length=20, nullable=false)
     */
    private $gsm;

    /**
     * @var string
     *
     * @ORM\Column(name="maison", type="string", length=20, nullable=false)
     */
    private $maison;

    /**
     * @var string
     *
     * @ORM\Column(name="horaires", type="string", length=255, nullable=false)
     */
    private $horaires;

    /**
     * @var string
     *
     * @ORM\Column(name="gsmSAUV", type="string", length=20, nullable=false)
     */
    private $gsmsauv;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer", nullable=false)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="wNotes", type="text", nullable=false)
     */
    private $wnotes;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=false)
     */
    private $statut;


}
