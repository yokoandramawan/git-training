<?php

namespace Ticket\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class Ticket extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('Ticket\\Entity\\Ticket');
    }
}
