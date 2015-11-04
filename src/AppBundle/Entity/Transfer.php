<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Transfer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TransferRepository")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Transfer
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destination", inversedBy="transfers")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id", )
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="min_pax", type="integer")
     */
    private $minPax;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_pax", type="integer")
     */
    private $maxPax;

    /**
     * @var string
     *
     * @ORM\Column(name="round_trip", type="string", length=2)
     */
    private $roundTrip;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Gedmo\Versioned
     */
    private $updated;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * Set description
     *
     * @param string $description
     *
     * @return Transfer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set minPax
     *
     * @param integer $minPax
     *
     * @return Transfer
     */
    public function setMinPax($minPax)
    {
        $this->minPax = $minPax;

        return $this;
    }

    /**
     * Get minPax
     *
     * @return integer
     */
    public function getMinPax()
    {
        return $this->minPax;
    }

    /**
     * Set maxPax
     *
     * @param integer $maxPax
     *
     * @return Transfer
     */
    public function setMaxPax($maxPax)
    {
        $this->maxPax = $maxPax;

        return $this;
    }

    /**
     * Get maxPax
     *
     * @return integer
     */
    public function getMaxPax()
    {
        return $this->maxPax;
    }

    /**
     * Set roundTrip
     *
     * @param string $roundTrip
     *
     * @return Transfer
     */
    public function setRoundTrip($roundTrip)
    {
        $this->roundTrip = $roundTrip;

        return $this;
    }

    /**
     * Get roundTrip
     *
     * @return string
     */
    public function getRoundTrip()
    {
        return $this->roundTrip;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Transfer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Transfer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Transfer
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Transfer
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Transfer
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set destination
     *
     * @param \AppBundle\Entity\Destination $destination
     *
     * @return Transfer
     */
    public function setDestination(Destination $destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
}