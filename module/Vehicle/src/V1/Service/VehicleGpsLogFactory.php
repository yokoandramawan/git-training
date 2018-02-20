<?php
namespace Vehicle\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleGpsLogFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleGpsLogMapper = $container->get('Vehicle\Mapper\VehicleGpsLog');
        $vehicleGpsLogHydrator = $container ->get('HydratorManager') ->get('Vehicle\Hydrator\VehicleGpsLog');
        $vehicleIdMapper = $container ->get('Vehicle\Mapper\Vehicle');
        return new VehicleGpsLog($vehicleGpsLogMapper, $vehicleGpsLogHydrator, $vehicleIdMapper);
    }
}
