<?php
namespace Ticket\V1\Rest\Ticket;


class TicketResourceFactory
{
    public function __invoke($services)
    {
        $ticketMapper = $services->get('Ticket\Mapper\Ticket');
        $ticketService = $services ->get('ticket');
        return new TicketResource($ticketMapper, $ticketService);
    }
}
