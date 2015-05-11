<?php

namespace MGN\KDynDnsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Records
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MGN\KDynDnsBundle\Entity\RecordsRepository")
 */
class Records
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\w+$/"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var datetime
     *
     * @ORM\Column(name="dateCountReset", type="datetime")
     */
    private $dateCountReset;


    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="records")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     */
    protected $zone;

    public function __construct()
    {
        $this->count=0;
        $this->dateCountReset=new \DateTime('now');
        $this->generateToken();
    }

    public function __toString()
    {
        return sprintf("%s.%s", $this->getName(), $this->getZone()->getFqdn());
    }

    /**
     * Generate an new token with random string
     */
    public function generateToken()
    {
        $length=16;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $this->token=$randomString;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Records
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set zone
     *
     * @param \MGN\KDynDnsBundle\Entity\Zone $zone
     * @return Records
     */
    public function setZone(\MGN\KDynDnsBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \MGN\KDynDnsBundle\Entity\Zone 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Records
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Records
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set dateCountReset
     *
     * @param \DateTime $dateCountReset
     * @return Records
     */
    public function setDateCountReset($dateCountReset)
    {
        $this->dateCountReset = $dateCountReset;

        return $this;
    }

    /**
     * Get dateCountReset
     *
     * @return \DateTime 
     */
    public function getDateCountReset()
    {
        return $this->dateCountReset;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Records
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }
}
