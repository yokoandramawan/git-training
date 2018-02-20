<?php
namespace Vehicle\V1\Service;

use Vehicle\V1\VehicleGpsLogEvent;
use Zend\EventManager\EventManagerAwareTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Vehicle\Entity\VehicleGpsLog as VehicleGpsLogEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Vehicle\Mapper\Vehicle as VehicleIdMapper;

class VehicleGpsLog
{
    use EventManagerAwareTrait;

    protected $vehicleGpsLogEvent;
    

    public function getVehicleGpsLogEvent()
    {
        if ($this->vehicleGpsLogEvent == null) {
            $this->vehicleGpsLogEvent = new VehicleGpsLogEvent();
        }

        return $this->vehicleGpsLogEvent;
    }

    public function setVehicleGpsLogEvent(VehicleGpsLogEvent $vehicleGpsLogEvent)
    {
        $this-> vehicleGpsLogEvent = $vehicleGpsLogEvent;
    }


    public function save(array $data, ZendInputFilter $inputFilter)
    {
        $vehicleGpsLogEvent = new VehicleGpsLogEvent();
        $vehicleGpsLogEvent->setInputFilter($inputFilter);
        $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_CREATE_VEHICLEGPSLOG);
        $create = $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
        if ($create->stopped()) {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_CREATE_VEHICLEGPSLOG_ERROR);
            $vehicleGpsLogEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            throw $vehicleGpsLogEvent->getException();
        } else {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_CREATE_VEHICLEGPSLOG_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            return $vehicleGpsLogEvent->getVehicleGpsLogEntity();
        }
    }


    public function update($vehicleGpsLogEntity, $inputFilter)
    {
        $vehicleGpsLogEvent = new VehicleGpsLogEvent();
        $vehicleGpsLogEvent->setVehicleGpsLogEntity($vehicleGpsLogEntity);
        $vehicleGpsLogEvent->setUpdateData($inputFilter->getValues());
        $vehicleGpsLogEvent->setInputFilter($inputFilter);
        $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_UPDATE_VEHICLEGPSLOG);
        $update = $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
        if ($update->stopped()) {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_UPDATE_VEHICLEGPSLOG_ERROR);
            $vehicleGpsLogEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            throw $vehicleGpsLogEvent->getException();
        } else {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_UPDATE_VEHICLEGPSLOG_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            return $vehicleGpsLogEvent->getVehicleGpsLogEntity();
        }
    }

    public function delete($id)
    {
        $vehicleGpsLogEvent = new VehicleGpsLogEvent();
        $vehicleGpsLogEvent->setDeletedUuid($id);
        $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_DELETE_VEHICLEGPSLOG);
        $create = $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
        if ($create->stopped()) {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_DELETE_VEHICLEGPSLOG_ERROR);
            $vehicleGpsLogEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            throw $vehicleGpsLogEvent->getException();
        } else {
            $vehicleGpsLogEvent->setName(VehicleGpsLogEvent::EVENT_DELETE_VEHICLEGPSLOG_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleGpsLogEvent);
            return true;
        }
    }
}
