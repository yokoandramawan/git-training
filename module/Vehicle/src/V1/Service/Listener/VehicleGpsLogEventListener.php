<?php
namespace Vehicle\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Vehicle\V1\VehicleGpsLogEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Vehicle\Mapper\VehicleGpsLog as VehicleGpsLogMapper;
use Vehicle\Entity\VehicleGpsLog as VehicleGpsLogEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Vehicle\Mapper\Vehicle as VehicleIdMapper;

class VehicleGpsLogEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $vehicleGpsLogEvent;
    protected $vehicleGpsLogMapper;
    protected $vehicleGpsLogHydrator;
    protected $vehicleIdMapper;

    /**
     * Constructor
     *
     * @param UserProfileMapper   $userProfileMapper
     * @param UserProfileHydrator $userProfileHydrator
     * @param array $config
     */
    public function __construct(
        VehicleGpsLogMapper $vehicleGpsLogMapper,
        DoctrineObject $vehicleGpsLogHydrator,
        VehicleIdMapper $vehicleIdMapper
    ) {
        $this -> setVehicleGpsLogMapper($vehicleGpsLogMapper);
        $this -> setVehicleGpsLogHydrator($vehicleGpsLogHydrator);
        $this -> setVehicleIdMapper($vehicleIdMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            VehicleGpsLogEvent::EVENT_CREATE_VEHICLEGPSLOG,
            [$this, 'createVehicleGpsLog'],
            500
        );

        $this->listeners[] = $events->attach(
            VehicleGpsLogEvent::EVENT_UPDATE_VEHICLEGPSLOG,
            [$this, 'updateVehicleGpsLog'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleGpsLogEvent::EVENT_DELETE_VEHICLEGPSLOG,
            [$this, 'deleteVehicleGpsLog'],
            499
        );
    }

    /**
     * Update Profile
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function createVehicleGpsLog(VehicleGpsLogEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $vehicleUuid    = $data['vehicle_id'];
            $vehicleObj     = $this->getVehicleIdMapper()->getEntityRepository()->findOneBy(['uuid' => $vehicleUuid]);
            if ($vehicleObj == '') {
                $event->setException('Cannot find uuid refrence');
                return;
            }

            $vehicleGpsLogEntity = new VehicleGpsLogEntity;
            $insertData = $event->getInputFilter()->getValues();
            $vehicleGpsLog = $this->getVehicleGpsLogHydrator()->hydrate($data, $vehicleGpsLogEntity);
            $vehicleGpsLog->setVehicle($vehicleObj);
            $result = $this->getVehicleGpsLogMapper()->save($vehicleGpsLog);
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

    public function updateVehicleGpsLog(VehicleGpsLogEvent $event)
    {
        try {
            $vehicleGpsLogEntity = $event->getVehicleGpsLogEntity();
            $updateData  = $event->getUpdateData();
            $updateData = (array) $updateData;
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            
            $vehicleUuid    = $data['vehicle_id'];
            $vehicleObj     = $this->getVehicleIdMapper()->getEntityRepository()->findOneBy(['uuid' => $vehicleUuid]);
            // var_dump($vehicleObj);exit;
            if ($vehicleObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $vehicleGpsLog     = $this->getVehicleGpsLogHydrator()->hydrate($updateData, $vehicleGpsLogEntity);
            $vehicleGpsLog->setVehicle($vehicleObj);
            $result     = $this->getVehicleGpsLogMapper()->save($vehicleGpsLog);
            $uuid   = $result->getUuid();
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : New data updated successfully! \nUUID: ".$uuid, ["function" => __FUNCTION__]);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function deleteVehicleGpsLog(VehicleGpsLogEvent $event)
    {
        try {
            $deletedUuid  = $event->getDeletedUuid();
            $vehicleGpsLogObj  = $this->getVehicleGpsLogMapper()->getEntityRepository()->findOneBy(['uuid' => $deletedUuid]);
            
            $this->getVehicleGpsLogMapper()->delete($vehicleGpsLogObj);
            $uuid   = $vehicleGpsLogObj->getUuid();
            $this->logger->log(\Psr\Log\LogLevel::INFO, "{function} : Data deleted successfully! \nUUID: ".$uuid, ["function" => __FUNCTION__]);            
            return true;

        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function setVehicleGpsLogMapper(VehicleGpsLogMapper $vehicleGpsLogMapper)
    {
        $this -> vehicleGpsLogMapper = $vehicleGpsLogMapper;
    }

    public function getVehicleGpsLogMapper()
    {
        return $this -> vehicleGpsLogMapper;
    }

    public function setVehicleGpsLogHydrator(DoctrineObject $vehicleGpsLogHydrator)
    {
        $this -> vehicleGpsLogHydrator = $vehicleGpsLogHydrator;
    }

    public function getVehicleGpsLogHydrator()
    {
        return $this -> vehicleGpsLogHydrator;
    }

    public function setVehicleIdMapper(VehicleIdMapper $vehicleIdMapper)
    {
        $this -> vehicleIdMapper = $vehicleIdMapper;
    }

    public function getVehicleIdMapper()
    {
        return $this -> vehicleIdMapper;
    }
}
