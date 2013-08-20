<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kwm2msuites
 *
 * @ORM\Table(name="kwm2msuites")
 * @ORM\Entity
 */
class Kwm2msuites
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
     * @var integer
     *
     * @ORM\Column(name="idKw", type="integer", nullable=false)
     */
    private $idkw;

    /**
     * @var integer
     *
     * @ORM\Column(name="idSuite", type="integer", nullable=false)
     */
    private $idsuite;


}
