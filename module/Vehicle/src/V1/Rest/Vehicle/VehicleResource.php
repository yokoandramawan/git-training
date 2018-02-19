<?php
namespace Vehicle\V1\Rest\Vehicle;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Vehicle\Mapper\Vehicle as VehicleMapper;
use Vehicle\Entity\Vehicle as VehicleEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;
use Vehicle\V1\Service\Vehicle as VehicleService;

class VehicleResource extends AbstractResourceListener
{
    protected $vehicleMapper;
    protected $vehicleService;

    public function __construct(
        VehicleMapper $vehicleMapper,
        VehicleService $vehicleService
    ) {
        $this -> setVehicleMapper($vehicleMapper);
        $this -> setVehicleService($vehicleService);
    }

    public function getVehicleService()
    {
        return $this->vehicleService;
    }

    public function setVehicleService(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }    

    public function setVehicleMapper($vehicleMapper)
    {
        $this -> vehicleMapper = $vehicleMapper;
        // return this;
    }

    public function getVehicleMapper()
    {
        return $this -> vehicleMapper;
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
        return $this->getVehicleService()->save($data, $inputFilter);
        
        // $inputFilter = $this ->getInputFilter()->getValues();
        // // var_dump($inputFilter);exit;
        // $userProfileUuid = $inputFilter['user_profile_uuid'];
        // $userProfileObj = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid'=> $userProfileUuid]);
        // if($userProfileObj == ''){
        //     $event->setException('Cannot find uuid reference');
        //     return;
        // }

        // $vehicleEntity = new VehicleEntity;
        // $inputFilter = (array) $inputFilter;
        // $vehicle = $this ->getVehicleHydrator()->hydrate($inputFilter, $vehicleEntity);
        // $vehicle->setUserProfileUuid($userProfileObj);
        // $result = $this ->getVehicleMapper()->save($vehicle);
        // // return new ApiProblem(405, 'The POST Yoko method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $vehicleEntity = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicleEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        }
        return $this->getVehicleService()->delete($id);

        // $vehicleEntity = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        // if (is_null($vehicleEntity)) {
        //     return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        // }
        // $this ->getVehicleMapper()->delete($vehicleEntity);
        // return true;
        // // return new ApiProblem(405, 'oke iya The DELETE method has not been defined for individual resources');
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
        $vehicle = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
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
        $data = $this -> getVehicleMapper() -> buildListPaginatorAdapter($params);
        return new \Zend\Paginator\Paginator($data);

        // $data = $this -> getVehicleMapper() -> getEntityRepository() -> findAll();
        // var_dump($data);exit;
        // return $data;
        // return new ApiProblem(405, 'Yoko Andramawan The GET method has not been defined for collections');
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
        $vehicleEntity = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicleEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        }
        $data = (array) $data;
        $inputFilter = $this->getInputFilter();
        return $this->getVehicleService()->update($vehicleEntity, $inputFilter);    

        // $vehicleEntity = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        // if (is_null($vehicleEntity)) {
        //     return new ApiProblemResponse(new ApiProblem(404, "Vehicle not found"));
        // }
        
        
        // $inputFilter = $this ->getInputFilter()->getValues();
        // $userProfileUuid = $inputFilter['user_profile_uuid'];
        // $inputFilter = (array) $inputFilter;
        // $userProfileObj = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
        // if ($userProfileObj == '') {
        //     $event->setException('Cannot find uuid reference');
        //     return;
        // }
        // $vehicle = $this ->getVehicleHydrator()->hydrate($inputFilter, $vehicleEntity);
        // $vehicle->setUserProfileUuid($userProfileObj);
        // $result = $this ->getVehicleMapper()->save($vehicle);
    }
}
