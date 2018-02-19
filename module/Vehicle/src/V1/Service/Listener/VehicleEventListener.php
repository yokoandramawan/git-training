<?php
namespace Vehicle\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Vehicle\V1\VehicleEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Vehicle\Mapper\Vehicle as VehicleMapper;
use Vehicle\Entity\Vehicle as VehicleEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;

class VehicleEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $vehicleEvent;
    protected $vehicleMapper;
    protected $vehicleHydrator;
    protected $userProfileMapper;

    /**
     * Constructor
     *
     * @param UserProfileMapper   $userProfileMapper
     * @param UserProfileHydrator $userProfileHydrator
     * @param array $config
     */
    public function __construct(
        VehicleMapper $vehicleMapper,
        DoctrineObject $vehicleHydrator,
        UserProfile $userProfileMapper
    ) {
        $this -> setVehicleMapper($vehicleMapper);
        $this -> setVehicleHydrator($vehicleHydrator);
        $this -> setUserProfileMapper($userProfileMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_CREATE_VEHICLE,
            [$this, 'createVehicle'],
            500
        );

        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_UPDATE_VEHICLE,
            [$this, 'updateVehicle'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_DELETE_VEHICLE,
            [$this, 'deleteVehicle'],
            499
        );
    }

    /**
     * Update Profile
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function createVehicle(VehicleEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                $event->setException('Cannot find uuid refrence');
                return;
            }

            $vehicleEntity = new VehicleEntity;
            $insertData = $event->getInputFilter()->getValues();
            $vehicle = $this->getVehicleHydrator()->hydrate($data, $vehicleEntity);
            $vehicle->setUserProfileUuid($userProfileObj);
            $result = $this->getVehicleMapper()->save($vehicle);
            $uuid   = $result->getUuid();

            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} {uuid}: New data created successfully ", 
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]);

            
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function updateVehicle(VehicleEvent $event)
    {
        try {
            $vehicleEntity = $event->getVehicleEntity();
            $updateData  = $event->getUpdateData();
            $updateData = (array) $updateData;
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $vehicle     = $this->getVehicleHydrator()->hydrate($updateData, $vehicleEntity);
            $vehicle->setUserProfileUuid($userProfileObj);
            $result     = $this->getVehicleMapper()->save($vehicle);
            $uuid   = $result->getUuid();
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data updated successfully! \nUUID: ".$uuid, ["function" => __FUNCTION__]);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function deleteVehicle(VehicleEvent $event)
    {
        try {
            $deletedUuid  = $event->getDeletedUuid();
            $vehicleObj  = $this->getVehicleMapper()->getEntityRepository()->findOneBy(['uuid' => $deletedUuid]);
            $this->getVehicleMapper()->delete($vehicleObj);
            $uuid   = $vehicleObj->getUuid();
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : Data deleted successfully! \nUUID: ".$uuid, ["function" => __FUNCTION__]);            
            return true;

        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
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
}
