<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturespospdf
 *
 * @ORM\Table(name="facturespospdf")
 * @ORM\Entity
 */
class Facturespospdf
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
     * @var float
     *
     * @ORM\Column(name="x", type="float", nullable=false)
     */
    private $x;

    /**
     * @var float
     *
     * @ORM\Column(name="y", type="float", nullable=false)
     */
    private $y;

    /**
     * @var integer
     *
     * @ORM\Column(name="idFact", type="integer", nullable=false)
     */
    private $idfact;

    /**
     * @var integer
     *
     * @ORM\Column(name="idChamp", type="integer", nullable=false)
     */
    private $idchamp;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=200, nullable=false)
     */
    private $contenu;


}
