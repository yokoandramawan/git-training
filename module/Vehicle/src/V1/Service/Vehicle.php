<?php
namespace Vehicle\V1\Service;

use Vehicle\V1\VehicleEvent;
use Zend\EventManager\EventManagerAwareTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Vehicle\Mapper\Vehicle as VehicleMapper;
use Vehicle\Entity\Vehicle as VehicleEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;

class Vehicle
{
    use EventManagerAwareTrait;

    protected $vehicleEvent;
    protected $vehicleMapper;
    protected $vehicleHydrator;
    protected $userProfileMapper;

    public function __construct(
        VehicleMapper $vehicleMapper,
        DoctrineObject $vehicleHydrator,
        UserProfile $userProfileMapper
    ) {

        $this -> setVehicleMapper($vehicleMapper);
        $this -> setVehicleHydrator($vehicleHydrator);
        $this -> setUserProfileMapper($userProfileMapper);
    }

    public function getVehicleEvent()
    {
        if ($this->vehicleEvent == null) {
            $this->vehicleEvent = new VehicleEvent();
        }

        return $this->vehicleEvent;
    }

    public function setVehicleEvent(VehicleEvent $vehicleEvent)
    {
        $this->vehicleEvent = $vehicleEvent;
    }

    public function setVehicleMapper(VehicleMapper $vehicleMapper)
    {
        $this -> vehicleMapper = $vehicleMapper;
    }

    public function getVehicleMapper()
    {
        return $this -> vehicleMapper;
    }

    public function setVehicleHydrator(DoctrineObject $vehicleHydrator)
    {
        $this -> vehicleHydrator = $vehicleHydrator;
    }

    public function getVehicleHydrator()
    {
        return $this -> vehicleHydrator;
    }

    public function setUserProfileMapper(UserProfile $userProfileMapper)
    {
        $this -> userProfileMapper = $userProfileMapper;
    }

    public function getUserProfileMapper()
    {
        return $this -> userProfileMapper;
    }


    public function save(array $data, ZendInputFilter $inputFilter)
    {
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setInputFilter($inputFilter);
        $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE);
        $create = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($create->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE_ERROR);
            $vehicleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            return $vehicleEvent->getVehicleEntity();
        }
    }


    public function update($vehicleEntity, $inputFilter)
    {
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setVehicleEntity($vehicleEntity);
        $vehicleEvent->setUpdateData($inputFilter->getValues());
        $vehicleEvent->setInputFilter($inputFilter);
        $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE);
        $update = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($update->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_ERROR);
            $vehicleEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            return $vehicleEvent->getVehicleEntity();
        }
    }

    public function delete($id)
    {
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setDeletedUuid($id);
        $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE);
        $create = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($create->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE_ERROR);
            $vehicleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            return true;
        }
    }
}
