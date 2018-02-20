<?php
namespace Vehicle\V1\Rest\VehicleGpsLog;


class VehicleGpsLogResourceFactory
{
    public function __invoke($services)
    {
        $vehicleGpsLogMapper = $services->get('Vehicle\Mapper\VehicleGpsLog');
        $vehicleGpsLogService = $services ->get('vehiclegpslog');
        return new VehicleGpsLogResource($vehicleGpsLogMapper, $vehicleGpsLogService);
    }
}
