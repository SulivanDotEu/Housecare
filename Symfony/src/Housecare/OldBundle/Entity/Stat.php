<?php

namespace Housecare\OldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 *
 * @ORM\Table(name="stat")
 * @ORM\Entity
 */
class Stat
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
     * @ORM\Column(name="datePlein", type="datetime", nullable=false)
     */
    private $dateplein;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="string", length=200, nullable=false)
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="toujoursLa", type="string", length=200, nullable=false)
     */
    private $toujoursla;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=50, nullable=false)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="parcours", type="string", length=200, nullable=false)
     */
    private $parcours;

    /**
     * @var string
     *
     * @ORM\Column(name="kewWords", type="string", length=200, nullable=false)
     */
    private $kewwords;

    /**
     * @var integer
     *
     * @ORM\Column(name="keyWordMatch", type="integer", nullable=false)
     */
    private $keywordmatch;

    /**
     * @var string
     *
     * @ORM\Column(name="phraseTitre", type="string", length=200, nullable=false)
     */
    private $phrasetitre;

    /**
     * @var string
     *
     * @ORM\Column(name="idSession", type="string", length=200, nullable=false)
     */
    private $idsession;

    /**
     * @var string
     *
     * @ORM\Column(name="newAdd", type="string", length=200, nullable=false)
     */
    private $newadd;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=200, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=200, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="IPCountry", type="string", length=30, nullable=false)
     */
    private $ipcountry;

    /**
     * @var string
     *
     * @ORM\Column(name="IPCountryC", type="string", length=5, nullable=false)
     */
    private $ipcountryc;

    /**
     * @var string
     *
     * @ORM\Column(name="IPCity", type="string", length=30, nullable=false)
     */
    private $ipcity;

    /**
     * @var string
     *
     * @ORM\Column(name="annGoogle", type="string", length=200, nullable=false)
     */
    private $anngoogle;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="text", nullable=false)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="lastTime", type="string", length=200, nullable=false)
     */
    private $lasttime;

    /**
     * @var string
     *
     * @ORM\Column(name="chat", type="text", nullable=false)
     */
    private $chat;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastChat", type="integer", nullable=false)
     */
    private $lastchat;

    /**
     * @var integer
     *
     * @ORM\Column(name="hide", type="integer", nullable=false)
     */
    private $hide;

    /**
     * @var string
     *
     * @ORM\Column(name="firstTime", type="string", length=200, nullable=false)
     */
    private $firsttime;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=200, nullable=false)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=200, nullable=false)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="testln", type="string", length=200, nullable=false)
     */
    private $testln;

    /**
     * @var string
     *
     * @ORM\Column(name="gets", type="string", length=200, nullable=false)
     */
    private $gets;

    /**
     * @var string
     *
     * @ORM\Column(name="gnal", type="string", length=200, nullable=false)
     */
    private $gnal;

    /**
     * @var string
     *
     * @ORM\Column(name="id_gnal", type="string", length=200, nullable=false)
     */
    private $idGnal;

    /**
     * @var string
     *
     * @ORM\Column(name="phplogin", type="string", length=200, nullable=false)
     */
    private $phplogin;

    /**
     * @var string
     *
     * @ORM\Column(name="server_user_agent", type="string", length=200, nullable=false)
     */
    private $serverUserAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="phplogin2", type="string", length=200, nullable=false)
     */
    private $phplogin2;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=200, nullable=false)
     */
    private $login;

    /**
     * @var integer
     *
     * @ORM\Column(name="idJob", type="integer", nullable=false)
     */
    private $idjob;


}
