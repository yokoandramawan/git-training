<?php

namespace Ticket\V1;

use Zend\EventManager\Event;
use Ticket\Entity\Ticket as TicketEntity;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class TicketEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_TICKET         = 'create.ticket';
    const EVENT_CREATE_TICKET_ERROR   = 'create.ticket.error';
    const EVENT_CREATE_TICKET_SUCCESS = 'create.ticket.success';

    const EVENT_UPDATE_TICKET         = 'update.ticket';
    const EVENT_UPDATE_TICKET_ERROR   = 'update.ticket.error';
    const EVENT_UPDATE_TICKET_SUCCESS = 'update.ticket.success';

    const EVENT_DELETE_TICKET         = 'delete.ticket';
    const EVENT_DELETE_TICKET_ERROR   = 'delete.ticket.error';
    const EVENT_DELETE_TICKET_SUCCESS = 'delete.ticket.success';
    /**#@-*/

    /**
     * @var User\Entity\FakeGpsLog
     */
    protected $ticketEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    protected $updateData;

    protected $deletedUuid;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @return the \User\Entity\FakeGpsLog
     */
    public function getTicketEntity()
    {
        return $this->ticketEntity;
    }

    /**
     * @param User\Entity\FakeGpsLog $fakegps
     */
    public function setTicketEntity(TicketEntity $ticketEntity)
    {
        $this->ticketEntity = $ticketEntity;
    }

    public function getUpdateData()
    {
        return $this->updateData;
    }

    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    public function getDeletedUuid()
    {
        return $this->deletedUuid;
    }

    public function setDeletedUuid($deletedUuid)
    {
        $this->deletedUuid = $deletedUuid;
    }

    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }
}
