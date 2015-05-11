<?php

namespace MGN\KDynDnsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Zone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MGN\KDynDnsBundle\Entity\ZoneRepository")
 */
class Zone
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
     * @ORM\Column(name="fqdn", type="string", length=255)
     */
    private $fqdn;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Records", mappedBy="zone")
     */
    private $records; 


    public function __toString()
    {
        return sprintf("%s", $this->fqdn);
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
     * Set fqdn
     *
     * @param string $fqdn
     * @return Zone
     */
    public function setFqdn($fqdn)
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * Get fqdn
     *
     * @return string 
     */
    public function getFqdn()
    {
        return $this->fqdn;
    }

    public function __construct()
    {
        $this->records = new ArrayCollection();
    }

    /**
     * Add records
     *
     * @param \MGN\KDynDnsBundle\Entity\Records $records
     * @return Zone
     */
    public function addRecord(\MGN\KDynDnsBundle\Entity\Records $records)
    {
        $this->records[] = $records;

        return $this;
    }

    /**
     * Remove records
     *
     * @param \MGN\KDynDnsBundle\Entity\Records $records
     */
    public function removeRecord(\MGN\KDynDnsBundle\Entity\Records $records)
    {
        $this->records->removeElement($records);
    }

    /**
     * Get records
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }
}
