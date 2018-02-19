<?php

namespace Vehicle\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timetampable\Traits\Timestampable as TimestampableTrait;
use User\Entity\UserProfile as UserProfile;
/**
 * Vehicle
 */
class Vehicle implements EntityInterface
{
    /**
     * @var string
     */
    private $plate;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $gpsId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;


    private $userProfileUuid;


    /**
     * Set plate
     *
     * @param string $plate
     *
     * @return Vehicle
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;

        return $this;
    }

    /**
     * Get plate
     *
     * @return string
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Vehicle
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set gpsId
     *
     * @param string $gpsId
     *
     * @return Vehicle
     */
    public function setGpsId($gpsId)
    {
        $this->gpsId = $gpsId;

        return $this;
    }

    /**
     * Get gpsId
     *
     * @return string
     */
    public function getGpsId()
    {
        return $this->gpsId;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Vehicle
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Vehicle
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Vehicle
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Vehicle
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
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    
    
    public function setUserProfileUuid($userProfileUuid)
    {
        $this->userProfileUuid = $userProfileUuid;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getUserProfileUuid()
    {
        return $this->userProfileUuid;
    }
    
}

