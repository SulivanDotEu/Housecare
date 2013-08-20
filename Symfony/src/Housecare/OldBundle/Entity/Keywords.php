<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keywords
 *
 * @ORM\Table(name="keywords")
 * @ORM\Entity
 */
class Keywords
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
     * @ORM\Column(name="keyword", type="string", length=150, nullable=false)
     */
    private $keyword;

    /**
     * @var integer
     *
     * @ORM\Column(name="justLike", type="integer", nullable=false)
     */
    private $justlike;

    /**
     * @var integer
     *
     * @ORM\Column(name="iterations", type="integer", nullable=false)
     */
    private $iterations;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrMots", type="integer", nullable=false)
     */
    private $nbrmots;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrChars", type="integer", nullable=false)
     */
    private $nbrchars;

    /**
     * @var integer
     *
     * @ORM\Column(name="suitesScanees", type="integer", nullable=false)
     */
    private $suitesscanees;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=5, nullable=false)
     */
    private $lang;


}
