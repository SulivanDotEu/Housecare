<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crontabreports
 *
 * @ORM\Table(name="crontabreports")
 * @ORM\Entity
 */
class Crontabreports
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
     * @ORM\Column(name="quoi", type="string", length=20, nullable=false)
     */
    private $quoi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="quand", type="datetime", nullable=false)
     */
    private $quand;


}
