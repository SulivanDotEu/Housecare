<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kwsuitesmots
 *
 * @ORM\Table(name="kwsuitesmots")
 * @ORM\Entity
 */
class Kwsuitesmots
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
     * @ORM\Column(name="mots", type="string", length=100, nullable=false)
     */
    private $mots;

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
     * @ORM\Column(name="iterations", type="integer", nullable=false)
     */
    private $iterations;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=5, nullable=false)
     */
    private $lang;


}
