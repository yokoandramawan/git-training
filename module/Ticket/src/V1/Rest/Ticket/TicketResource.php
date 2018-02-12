<?php
namespace Ticket\V1\Rest\Ticket;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Ticket\Mapper\Ticket as TicketMapper;
use Ticket\Entity\Ticket as TicketEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;
use Ticket\V1\Service\Ticket as TicketService;

class TicketResource extends AbstractResourceListener
{
    protected $ticketMapper;
    protected $ticketService;

    public function __construct(
        TicketMapper $ticketMapper,
        TicketService $ticketService
    ) {

        $this -> setTicketMapper($ticketMapper);
        $this -> setTicketService($ticketService);
    }

    public function getTicketService()
    {
        return $this->ticketService;
    }

    public function setTicketService(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
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
        return $this->getTicketService()->save($data, $inputFilter);
    }

    public function delete($id)
    {
        $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($ticketEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Ticket not found"));
        }
        return $this->getTicketService()->delete($id);        
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
        $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($ticketEntity)) {
            return new ApiProblemResponse(new ApiProblem(404, "Ticket not found"));
        }
        $data = (array) $data;
        $inputFilter = $this->getInputFilter();
        return $this->getTicketService()->update($ticketEntity, $inputFilter);
    }
}
