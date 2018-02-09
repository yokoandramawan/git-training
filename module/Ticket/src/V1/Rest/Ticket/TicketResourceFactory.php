<?php
namespace Ticket\V1\Rest\Ticket;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TicketResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper = $container->get('Ticket\Mapper\Ticket');
        $ticketHydrator = $container ->get('HydratorManager') ->get('Ticket\Hydrator\Ticket');
        $userProfileMapper = $container ->get('User\Mapper\UserProfile');
        // var_dump($ticketHydrator);exit;
        return new TicketResource($ticketMapper, $ticketHydrator, $userProfileMapper);
    }
}
