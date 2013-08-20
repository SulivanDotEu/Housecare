<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturesa6pc
 *
 * @ORM\Table(name="facturesa6pc")
 * @ORM\Entity
 */
class Facturesa6pc
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
     * @ORM\Column(name="idFactExcel", type="integer", nullable=false)
     */
    private $idfactexcel;

    /**
     * @var float
     *
     * @ORM\Column(name="tva", type="float", nullable=false)
     */
    private $tva;

    /**
     * @var float
     *
     * @ORM\Column(name="base", type="float", nullable=false)
     */
    private $base;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="regTva", type="integer", nullable=false)
     */
    private $regtva;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=60, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cpEtVille", type="string", length=40, nullable=false)
     */
    private $cpetville;

    /**
     * @var string
     *
     * @ORM\Column(name="numFacture", type="string", length=10, nullable=false)
     */
    private $numfacture;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFacture", type="string", length=12, nullable=false)
     */
    private $datefacture;

    /**
     * @var integer
     *
     * @ORM\Column(name="customerId", type="integer", nullable=false)
     */
    private $customerid;

    /**
     * @var string
     *
     * @ORM\Column(name="gsm", type="string", length=20, nullable=false)
     */
    private $gsm;

    /**
     * @var integer
     *
     * @ORM\Column(name="action", type="integer", nullable=false)
     */
    private $action;

    /**
     * @var integer
     *
     * @ORM\Column(name="accesPdf", type="integer", nullable=false)
     */
    private $accespdf;


}
