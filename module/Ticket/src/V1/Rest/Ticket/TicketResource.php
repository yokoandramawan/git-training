<?php
namespace Ticket\V1\Rest\Ticket;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Ticket\Mapper\Ticket as TicketMapper;
use Ticket\Entity\Ticket as TicketEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;

class TicketResource extends AbstractResourceListener
{
    protected $ticketMapper;
    protected $ticketHydrator;
    protected $userProfileMapper;

    public function __construct(
        TicketMapper $ticketMapper, 
        DoctrineObject $ticketHydrator,
        UserProfile $userProfileMapper)
    {
        $this -> setTicketMapper($ticketMapper);
        $this -> setTicketHydrator($ticketHydrator);
        $this -> setUserProfileMapper($userProfileMapper);
    }
    
    public function setUserProfileMapper(UserProfile $userProfileMapper)
    {
        $this -> userProfileMapper = $userProfileMapper;
    }
    
    public function getUserProfileMapper()
    {
        return $this -> userProfileMapper;
    }


    public function setTicketMapper($ticketMapper)
    {
        $this -> ticketMapper = $ticketMapper;
        // return $this;
    }

    public function getTicketMapper()
    {
        return $this -> ticketMapper;
    }

    public function setTicketHydrator($ticketHydrator)
    {
        $this -> ticketHydrator = $ticketHydrator;
    }

    public function getTicketHydrator()
    {
        return $this -> ticketHydrator;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $inputFilter = $this ->getInputFilter()->getValues();
        var_dump($inputFilter);exit;
        $userProfileUuid = $inputFilter['user_profile_uuid'];
        $userProfileObj = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid'=> $userProfileUuid]);
        if($userProfileObj == ''){
            $event->setException('Cannot find uuid reference');
            return;
        }

        $ticketEntity = new TicketEntity;
        $inputFilter = (array) $inputFilter;
        $ticket = $this ->getTicketHydrator()->hydrate($inputFilter, $ticketEntity);
        $ticket->setUserProfileUuid($userProfileObj);
        $result = $this ->getTicketMapper()->save($ticket);
        // return new ApiProblem(405, 'test okeThe POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($ticketEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Ticket not found"));
        }
        $this ->getTicketMapper()->delete($ticketEntity);
        return true;
        // return new ApiProblem(405, 'oke iya The DELETE method has not been defined for individual resources');
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
        $ticket = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($ticket)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        return $ticket;
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
        $data = $this -> getTicketMapper() -> buildListPaginatorAdapter($params);
        // var_dump($data);exit;
        return new \Zend\Paginator\Paginator($data);

        // return new ApiProblem(405, 'The GET method has not been defined for collections');
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
        $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($ticketEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }
        $inputFilter = $this ->getInputFilter()->getValues();
        $inputFilter = (array) $inputFilter;
        // var_dump(get_class ($ticket));exit;
        $ticket = $this ->getTicketHydrator()->hydrate($inputFilter, $ticketEntity);
        // var_dump(get_class($this ->getTicketMapper()->save));exit;
        $result = $this ->getTicketMapper()->save($ticket);
        // return new ApiProblem(405, 'tesssThe PUT method has not been defined for individual resources');
    }
}
