<?php
namespace Ticket\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Ticket\V1\TicketEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Ticket\Mapper\Ticket as TicketMapper;
use Ticket\Entity\Ticket as TicketEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfile;

class TicketEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $ticketEvent;
    protected $ticketMapper;
    protected $ticketHydrator;
    protected $userProfileMapper;

    /**
     * Constructor
     *
     * @param UserProfileMapper   $userProfileMapper
     * @param UserProfileHydrator $userProfileHydrator
     * @param array $config
     */
    public function __construct(
        TicketMapper $ticketMapper,
        DoctrineObject $ticketHydrator,
        UserProfile $userProfileMapper
    ) {
        $this -> setTicketMapper($ticketMapper);
        $this -> setTicketHydrator($ticketHydrator);
        $this -> setUserProfileMapper($userProfileMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_CREATE_TICKET,
            [$this, 'createTicket'],
            500
        );

        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_UPDATE_TICKET,
            [$this, 'updateTicket'],
            499
        );

        $this->listeners[] = $events->attach(
            TicketEvent::EVENT_DELETE_TICKET,
            [$this, 'deleteTicket'],
            499
        );
    }

    /**
     * Update Profile
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function createTicket(TicketEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                $event->setException('Cannot find uuid refrence');
                return;
            }

            $ticketEntity = new TicketEntity;
            $insertData = $event->getInputFilter()->getValues();
            $ticket = $this->getTicketHydrator()->hydrate($data, $ticketEntity);
            $ticket->setUserProfileUuid($userProfileObj);
            $result = $this->getTicketMapper()->save($ticket);

        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function updateTicket(TicketEvent $event)
    {
        try {
            $ticketEntity = $event->getTicketEntity();
            $updateData  = $event->getUpdateData();
            $updateData = (array) $updateData;
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            
            $userProfileUuid    = $data['user_profile_uuid'];
            $userProfileObj     = $this->getUserProfileMapper()->getEntityRepository()->findOneBy(['uuid' => $userProfileUuid]);
            if ($userProfileObj == '') {
                return new ApiProblem(500, 'Cannot find uuid refrence');
            }

            $ticket     = $this->getTicketHydrator()->hydrate($updateData, $ticketEntity);
            $ticket->setUserProfileUuid($userProfileObj);
            $result     = $this->getTicketMapper()->save($ticket);

        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteTicket(TicketEvent $event)
    {
        try {
            $deletedUuid  = $event->getDeletedUuid();
            $ticketObj  = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $deletedUuid]);
            $this->getTicketMapper()->delete($ticketObj);
            return true;

        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
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
}
