<?php
namespace Ticket\V1\Console\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TicketControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketMapper = $container->get('Ticket\Mapper\Ticket');
        $ticketController = new TicketController($ticketMapper);
        $ticketController->setLogger($container->get("logger_default"));
        return $ticketController;
    }
}