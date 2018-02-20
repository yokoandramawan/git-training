<?php
namespace Vehicle\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleGpsLogEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleGpsLogMapper = $container->get('Vehicle\Mapper\VehicleGpsLog');
        $vehicleGpsLogHydrator = $container ->get('HydratorManager') ->get('Vehicle\Hydrator\VehicleGpsLog');
        $vehicleIdMapper = $container ->get('Vehicle\Mapper\Vehicle');
        $vehicleGpsLogEventListener = new VehicleGpsLogEventListener($vehicleGpsLogMapper, $vehicleGpsLogHydrator, $vehicleIdMapper);
        $vehicleGpsLogEventListener->setLogger($container->get("logger_default"));
        return $vehicleGpsLogEventListener;
    }
}
