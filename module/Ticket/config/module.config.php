<?php
return [
    'service_manager' => [
        'factories' => [
            'ticket' => \Ticket\V1\Service\TicketFactory::class,
            'ticket.listener' => \Ticket\V1\Service\Listener\TicketEventListenerFactory::class,
            \Ticket\V1\Rest\Ticket\TicketResource::class => \Ticket\V1\Rest\Ticket\TicketResourceFactory::class,
        ],
        'abstract_factories' => [
            0 => \Ticket\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Ticket\\Hydrator\\Ticket' => \Ticket\V1\Hydrator\TicketHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ticket.rest.ticket' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/ticket[/:ticket_id]',
                    'defaults' => [
                        'controller' => 'Ticket\\V1\\Rest\\Ticket\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'ticket.rest.ticket',
        ],
    ],
    'zf-rest' => [
        'Ticket\\V1\\Rest\\Ticket\\Controller' => [
            'listener' => \Ticket\V1\Rest\Ticket\TicketResource::class,
            'route_name' => 'ticket.rest.ticket',
            'route_identifier_name' => 'ticket_id',
            'collection_name' => 'ticket',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'status',
            ],
            'page_size' => '25',
            'page_size_param' => null,
            'entity_class' => \Ticket\Entity\Ticket::class,
            'collection_class' => \Ticket\V1\Rest\Ticket\TicketCollection::class,
            'service_name' => 'Ticket',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Ticket\\V1\\Rest\\Ticket\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Ticket\\V1\\Rest\\Ticket\\Controller' => [
                0 => 'application/vnd.ticket.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Ticket\\V1\\Rest\\Ticket\\Controller' => [
                0 => 'application/vnd.ticket.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Ticket\V1\Rest\Ticket\TicketEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'ticket.rest.ticket',
                'route_identifier_name' => 'ticket_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            \Ticket\V1\Rest\Ticket\TicketCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'ticket.rest.ticket',
                'route_identifier_name' => 'ticket_id',
                'is_collection' => true,
            ],
            \Ticket\Entity\Ticket::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'ticket.rest.ticket',
                'route_identifier_name' => 'ticket_id',
                'hydrator' => 'Ticket\\Hydrator\\Ticket',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Ticket\\V1\\Rest\\Ticket\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'zf-content-validation' => [
        'Ticket\\V1\\Rest\\Ticket\\Controller' => [
            'input_filter' => 'Ticket\\V1\\Rest\\Ticket\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Ticket\\V1\\Rest\\Ticket\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'continue_if_empty' => true,
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'description',
                'continue_if_empty' => true,
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'status',
                'continue_if_empty' => true,
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'code',
                'continue_if_empty' => true,
            ],
            4 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'user_profile_uuid',
            ],
        ],
    ],
];
