<?php
namespace Ticket\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TicketEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper = $container->get('Ticket\Mapper\Ticket');
        $ticketHydrator = $container ->get('HydratorManager') ->get('Ticket\Hydrator\Ticket');
        $userProfileMapper = $container ->get('User\Mapper\UserProfile');
        return new TicketEventListener($ticketMapper, $ticketHydrator, $userProfileMapper);
    }
}
