<?php
namespace Vehicle\V1\Rest\VehicleGpsLog;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Vehicle\Mapper\VehicleGpsLog as VehicleGpsLogMapper;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Vehicle\V1\Service\VehicleGpsLog as VehicleGpsLogService;

class VehicleGpsLogResource extends AbstractResourceListener
{
    protected $vehicleGpsLogMapper;
    protected $vehicleGpsLogService;

    public function __construct(
        VehicleGpsLogMapper $vehicleGpsLogMapper,
        VehicleGpsLogService $vehicleGpsLogService
    ) {
        $this -> setVehicleGpsLogMapper($vehicleGpsLogMapper);
        $this -> setVehicleGpsLogService($vehicleGpsLogService);
    }

    public function setVehicleGpsLogMapper($vehicleGpsLogMapper)
    {
    $this -> vehicleGpsLogMapper = $vehicleGpsLogMapper;
    }

    public function getVehicleGpsLogMapper()
    {
    return $this -> vehicleGpsLogMapper;
    }

    public function getVehicleGpsLogService()
    {
        return $this->vehicleGpsLogService;
    }

    public function setVehicleGpsLogService(VehicleGpsLogService $vehicleGpsLogService)
    {
        $this->vehicleGpsLogService = $vehicleGpsLogService;
    }  

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = (array) $data;
        $inputFilter = $this->getInputFilter();
        return $this->getVehicleGpsLogService()->save($data, $inputFilter);
        // $ticketEntity = new TicketEntity;
        // return new ApiProblem(405, 'Oke Yoko The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $vehicleGpsLogEntity = $this->getVehicleGpsLogMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicleGpsLogEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        }
        return $this->getVehicleGpsLogService()->delete($id);
        // return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $vehicle = $this->getVehicleGpsLogMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicle)) {
        return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        }
        return $vehicle;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $params = $params->toArray();
        $data = $this -> getVehicleGpsLogMapper() -> buildListPaginatorAdapter($params);
        return new \Zend\Paginator\Paginator($data);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $vehicleGpsLogEntity = $this->getVehicleGpsLogMapper()->fetchOneBy(['uuid' => $id]);
        // var_dump($vehicleGpsLogEntity);exit;
        if (is_null($vehicleGpsLogEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        }
        $data = (array) $data;
        $inputFilter = $this->getInputFilter();
        return $this->getVehicleGpsLogService()->update($vehicleGpsLogEntity, $inputFilter);   
        // return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
