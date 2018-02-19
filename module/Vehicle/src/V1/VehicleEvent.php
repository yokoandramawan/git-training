<?php

namespace Vehicle\V1;

use Zend\EventManager\Event;
use Vehicle\Entity\Vehicle as VehicleEntity;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class VehicleEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_VEHICLE         = 'create.vehicle';
    const EVENT_CREATE_VEHICLE_ERROR   = 'create.vehicle.error';
    const EVENT_CREATE_VEHICLE_SUCCESS = 'create.vehicle.success';

    const EVENT_UPDATE_VEHICLE         = 'update.vehicle';
    const EVENT_UPDATE_VEHICLE_ERROR   = 'update.vehicle.error';
    const EVENT_UPDATE_VEHICLE_SUCCESS = 'update.vehicle.success';

    const EVENT_DELETE_VEHICLE         = 'delete.vehicle';
    const EVENT_DELETE_VEHICLE_ERROR   = 'delete.vehicle.error';
    const EVENT_DELETE_VEHICLE_SUCCESS = 'delete.vehicle.success';
    /**#@-*/

    /**
     * @var User\Entity\FakeGpsLog
     */
    protected $vehicleEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    protected $updateData;

    protected $deletedUuid;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @return the \User\Entity\FakeGpsLog
     */
    public function getVehicleEntity()
    {
        return $this->vehicleEntity;
    }

    /**
     * @param User\Entity\FakeGpsLog $fakegps
     */
    public function setVehicleEntity(VehicleEntity $vehicleEntity)
    {
        $this->vehicleEntity = $vehicleEntity;
    }

    public function getUpdateData()
    {
        return $this->updateData;
    }

    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    public function getDeletedUuid()
    {
        return $this->deletedUuid;
    }

    public function setDeletedUuid($deletedUuid)
    {
        $this->deletedUuid = $deletedUuid;
    }

    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }
}
