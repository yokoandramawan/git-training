<?php
namespace Ticket\V1\Service;

use Ticket\V1\TicketEvent;
use Zend\EventManager\EventManagerAwareTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Ticket\Mapper\Ticket as TicketMapper;
use Ticket\Entity\Ticket as TicketEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;

class Ticket
{
    use EventManagerAwareTrait;

    protected $ticketEvent;
    protected $ticketMapper;
    protected $ticketHydrator;
    protected $userProfileMapper;

    public function __construct(
        TicketMapper $ticketMapper,
        DoctrineObject $ticketHydrator,
        UserProfile $userProfileMapper
    ) {

        $this -> setTicketMapper($ticketMapper);
        $this -> setTicketHydrator($ticketHydrator);
        $this -> setUserProfileMapper($userProfileMapper);
    }

    public function getTicketEvent()
    {
        if ($this->ticketEvent == null) {
            $this->ticketEvent = new TicketEvent();
        }

        return $this->ticketEvent;
    }

    public function setTicketEvent(TicketEvent $ticketEvent)
    {
        $this->ticketEvent = $ticketEvent;
    }

    public function setTicketMapper(TicketMapper $ticketMapper)
    {
        $this -> ticketMapper = $ticketMapper;
    }

    public function getTicketMapper()
    {
        return $this -> ticketMapper;
    }

    public function setTicketHydrator(DoctrineObject $ticketHydrator)
    {
        $this -> ticketHydrator = $ticketHydrator;
    }

    public function getTicketHydrator()
    {
        return $this -> ticketHydrator;
    }

    public function setUserProfileMapper(UserProfile $userProfileMapper)
    {
        $this -> userProfileMapper = $userProfileMapper;
    }

    public function getUserProfileMapper()
    {
        return $this -> userProfileMapper;
    }


    public function save(array $data, ZendInputFilter $inputFilter)
    {
        $ticketEvent = new TicketEvent();
        $ticketEvent->setInputFilter($inputFilter);
        $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET);
        $create = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($create->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET_ERROR);
            $ticketEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_CREATE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return $ticketEvent->getTicketEntity();
        }
    }


    public function update($ticketEntity, $inputFilter)
    {
        $ticketEvent = new TicketEvent();
        $ticketEvent->setTicketEntity($ticketEntity);
        $ticketEvent->setUpdateData($inputFilter->getValues());
        $ticketEvent->setInputFilter($inputFilter);
        $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET);
        $update = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($update->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_ERROR);
            $ticketEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_UPDATE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return $ticketEvent->getTicketEntity();
        }
        // $inputFilter = $inputFilter->getValues();
        // $userProfileUuid = $inputFilter['user_profile_uuid'];
        // $inputFilter = (array) $inputFilter;
        // $userProfileObj = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
        // if ($userProfileObj == '') {
        //     $event->setException('Cannot find uuid reference');
        //     return;
        // }
        // $ticket = $this ->getTicketHydrator()->hydrate($inputFilter, $ticketEntity);
        // $ticket->setUserProfileUuid($userProfileObj);
        // $result = $this ->getTicketMapper()->save($ticket);
    }

    public function delete($id)
    {
        $ticketEvent = new TicketEvent();
        $ticketEvent->setDeletedUuid($id);
        $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET);
        $create = $this->getEventManager()->triggerEvent($ticketEvent);
        if ($create->stopped()) {
            $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET_ERROR);
            $ticketEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($ticketEvent);
            throw $ticketEvent->getException();
        } else {
            $ticketEvent->setName(TicketEvent::EVENT_DELETE_TICKET_SUCCESS);
            $this->getEventManager()->triggerEvent($ticketEvent);
            return true;
        }

        // $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        // $this ->getTicketMapper()->delete($ticketEntity);
        // return true;
    }
}
