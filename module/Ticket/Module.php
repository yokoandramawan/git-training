<?php
namespace Ticket;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements ApigilityProviderInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        // ticket
        $ticketService = $serviceManager->get('ticket');
        $ticketEventListener = $serviceManager->get('ticket.listener');
        $ticketEventListener->attach($ticketService->getEventManager());
    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            // Describe available commands
            'FetchById [--verbose|-v] <uuid>' => 'Reset password for a user',

            // Describe expected parameters
            ['uuid' , 'UUID',        'Isi Uuid' ],
            [ '--verbose|-v', '(optional) turn on verbose mode'        ],
        ];
    }
}
