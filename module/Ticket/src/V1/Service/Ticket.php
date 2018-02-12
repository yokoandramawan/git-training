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

    public function getProfileEvent()
    {
        if ($this->profileEvent == null) {
            $this->profileEvent = new ProfileEvent();
        }

        return $this->profileEvent;
    }

    public function setProfileEvent(ProfileEvent $profileEvent)
    {
        $this->profileEvent = $profileEvent;
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
        $inputFilter = $inputFilter->getValues();
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
    }


    public function update($ticketEntity, $inputFilter)
    {
        $inputFilter = $inputFilter->getValues();
        $userProfileUuid = $inputFilter['user_profile_uuid'];
        $inputFilter = (array) $inputFilter;
        $userProfileObj = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
        if ($userProfileObj == '') {
            $event->setException('Cannot find uuid reference');
            return;
        }
        $ticket = $this ->getTicketHydrator()->hydrate($inputFilter, $ticketEntity);
        $ticket->setUserProfileUuid($userProfileObj);
        $result = $this ->getTicketMapper()->save($ticket);
    }

    public function delete($id)
    {
        $ticketEntity = $this->getTicketMapper()->fetchOneBy(['uuid' => $id]);
        $this ->getTicketMapper()->delete($ticketEntity);
        return true;
    }
}
