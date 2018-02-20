<?php

namespace Vehicle\V1;

use Zend\EventManager\Event;
use Vehicle\Entity\VehicleGpsLog as VehicleGpsLogEntity;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class VehicleGpsLogEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_VEHICLEGPSLOG         = 'create.vehiclegpslog';
    const EVENT_CREATE_VEHICLEGPSLOG_ERROR   = 'create.vehiclegpslog.error';
    const EVENT_CREATE_VEHICLEGPSLOG_SUCCESS = 'create.vehiclegpslog.success';

    const EVENT_UPDATE_VEHICLEGPSLOG         = 'update.vehiclegpslog';
    const EVENT_UPDATE_VEHICLEGPSLOG_ERROR   = 'update.vehiclegpslog.error';
    const EVENT_UPDATE_VEHICLEGPSLOG_SUCCESS = 'update.vehiclegpslog.success';

    const EVENT_DELETE_VEHICLEGPSLOG         = 'delete.vehiclegpslog';
    const EVENT_DELETE_VEHICLEGPSLOG_ERROR   = 'delete.vehiclegpslog.error';
    const EVENT_DELETE_VEHICLEGPSLOG_SUCCESS = 'delete.vehiclegpslog.success';
    /**#@-*/

    /**
     * @var User\Entity\FakeGpsLog
     */
    protected $vehicleGpsLogEntity;

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
    public function getVehicleGpsLogEntity()
    {
        return $this->vehicleGpsLogEntity;
    }

    /**
     * @param User\Entity\FakeGpsLog $fakegps
     */
    public function setVehicleGpsLogEntity(VehicleGpsLogEntity $vehicleGpsLogEntity)
    {
        $this->vehicleGpsLogEntity = $vehicleGpsLogEntity;
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
