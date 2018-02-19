<?php
namespace Vehicle\V1\Hydrator;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;
use Zend\Hydrator\Filter\FilterComposite;

/**
 * Hydrator for Doctrine Entity
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class VehicleHydratorFactory implements FactoryInterface
{
    /**
     * Create a service for DoctrineObject Hydrator
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $hydrator = new DoctrineObject($entityManager);
        $hydrator->addStrategy('userProfileUuid', new \Vehicle\V1\Hydrator\Strategy\UserProfileStrategy);
        $hydrator->addStrategy('createdAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addFilter('exclude', function ($property) {
            if (in_array($property, ['deletedAt', 'updatedAt'])) {
                return false;
            }

            return true;
        }, FilterComposite::CONDITION_AND);
        return $hydrator;
    }
}
