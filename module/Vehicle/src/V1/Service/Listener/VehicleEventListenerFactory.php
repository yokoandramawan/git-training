<?php
namespace Vehicle\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleMapper = $container->get('Vehicle\Mapper\Vehicle');
        $vehicleHydrator = $container ->get('HydratorManager') ->get('Vehicle\Hydrator\Vehicle');
        $userProfileMapper = $container ->get('User\Mapper\UserProfile');
        $vehicleEventListener = new VehicleEventListener($vehicleMapper, $vehicleHydrator, $userProfileMapper);
        $vehicleEventListener->setLogger($container->get("logger_default"));
        return $vehicleEventListener;
    }
}
