<?php

namespace Vehicle\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timetampable\Traits\Timestampable as TimestampableTrait;
use Vehicle\Entity\Vehicle as Vehicle;

/**
 * VehicleGpsLog
 */
class VehicleGpsLog implements EntityInterface
{
    /**
     * @var string
     */
    private $gpsId;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $speed;

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

    /**
     * @var \Vehicle\Entity\Vehicle
     */
    private $vehicle;


    /**
     * Set gpsId
     *
     * @param string $gpsId
     *
     * @return VehicleGpsLog
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
     * Set latitude
     *
     * @param float $latitude
     *
     * @return VehicleGpsLog
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return VehicleGpsLog
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set speed
     *
     * @param float $speed
     *
     * @return VehicleGpsLog
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return VehicleGpsLog
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
     * @return VehicleGpsLog
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
     * @return VehicleGpsLog
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

    /**
     * Set vehicle
     *
     * @param \Vehicle\Entity\Vehicle $vehicle
     *
     * @return VehicleGpsLog
     */
    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \Vehicle\Entity\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }
}

