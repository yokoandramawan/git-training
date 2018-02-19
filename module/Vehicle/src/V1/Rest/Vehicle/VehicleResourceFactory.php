<?php
namespace Vehicle\V1\Rest\Vehicle;


class VehicleResourceFactory
{
    public function __invoke($services)
    {
        $vehicleMapper = $services->get('Vehicle\Mapper\Vehicle');
        $vehicleService = $services ->get('vehicle');
        return new VehicleResource($vehicleMapper, $vehicleService);
    }
}
