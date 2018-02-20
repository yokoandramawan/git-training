<?php
namespace Vehicle\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleMapper = $container->get('Vehicle\Mapper\Vehicle');
        $vehicleHydrator = $container ->get('HydratorManager') ->get('Vehicle\Hydrator\Vehicle');
        $userProfileMapper = $container ->get('User\Mapper\UserProfile');
        return new Vehicle($vehicleMapper, $vehicleHydrator, $userProfileMapper);
    }
}
