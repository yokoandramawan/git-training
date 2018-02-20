<?php
return [
    'service_manager' => [
        'factories' => [
            'vehicle' => \Vehicle\V1\Service\VehicleFactory::class,
            'vehicle.listener' => \Vehicle\V1\Service\Listener\VehicleEventListenerFactory::class,
            'vehiclegpslog' => \Vehicle\V1\Service\VehicleGpsLogFactory::class,
            'vehiclegpslog.listener' => \Vehicle\V1\Service\Listener\VehicleGpsLogEventListenerFactory::class,
            \Vehicle\V1\Rest\Vehicle\VehicleResource::class => \Vehicle\V1\Rest\Vehicle\VehicleResourceFactory::class,
            \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogResource::class => \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogResourceFactory::class,
        ],
        'abstract_factories' => [
            0 => \Vehicle\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Vehicle\\Hydrator\\Vehicle' => \Vehicle\V1\Hydrator\VehicleHydratorFactory::class,
            'Vehicle\\Hydrator\\VehicleGpsLog' => \Vehicle\V1\Hydrator\VehicleGpsLogHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'vehicle.rest.vehicle' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/vehicle[/:vehicle_id]',
                    'defaults' => [
                        'controller' => 'Vehicle\\V1\\Rest\\Vehicle\\Controller',
                    ],
                ],
            ],
            'vehicle.rest.vehicle-gps-log' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/vehicle-gps-log[/:vehicle_gps_log_id]',
                    'defaults' => [
                        'controller' => 'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'vehicle.rest.vehicle',
            1 => 'vehicle.rest.vehicle-gps-log',
        ],
    ],
    'zf-rest' => [
        'Vehicle\\V1\\Rest\\Vehicle\\Controller' => [
            'listener' => \Vehicle\V1\Rest\Vehicle\VehicleResource::class,
            'route_name' => 'vehicle.rest.vehicle',
            'route_identifier_name' => 'vehicle_id',
            'collection_name' => 'vehicle',
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
            'page_size' => '10',
            'page_size_param' => null,
            'entity_class' => \Vehicle\Entity\Vehicle::class,
            'collection_class' => \Vehicle\V1\Rest\Vehicle\VehicleCollection::class,
            'service_name' => 'Vehicle',
        ],
        'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => [
            'listener' => \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogResource::class,
            'route_name' => 'vehicle.rest.vehicle-gps-log',
            'route_identifier_name' => 'vehicle_gps_log_id',
            'collection_name' => 'vehicle_gps_log',
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
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Vehicle\Entity\VehicleGpsLog::class,
            'collection_class' => \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogCollection::class,
            'service_name' => 'VehicleGpsLog',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Vehicle\\V1\\Rest\\Vehicle\\Controller' => 'HalJson',
            'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Vehicle\\V1\\Rest\\Vehicle\\Controller' => [
                0 => 'application/vnd.vehicle.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => [
                0 => 'application/vnd.vehicle.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Vehicle\\V1\\Rest\\Vehicle\\Controller' => [
                0 => 'application/vnd.vehicle.v1+json',
                1 => 'application/json',
            ],
            'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => [
                0 => 'application/vnd.vehicle.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Vehicle\V1\Rest\Vehicle\VehicleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'vehicle.rest.vehicle',
                'route_identifier_name' => 'vehicle_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Vehicle\V1\Rest\Vehicle\VehicleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'vehicle.rest.vehicle',
                'route_identifier_name' => 'vehicle_id',
                'is_collection' => true,
            ],
            \Vehicle\Entity\Vehicle::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'vehicle.rest.vehicle',
                'route_identifier_name' => 'vehicle_id',
                'hydrator' => 'Vehicle\\Hydrator\\Vehicle',
            ],
            \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'vehicle.rest.vehicle-gps-log',
                'route_identifier_name' => 'vehicle_gps_log_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Vehicle\V1\Rest\VehicleGpsLog\VehicleGpsLogCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'vehicle.rest.vehicle-gps-log',
                'route_identifier_name' => 'vehicle_gps_log_id',
                'is_collection' => true,
            ],
            'VehicleGpsLog\\Entity\\VehicleGpsLog' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'vehicle.rest.vehicle-gps-log',
                'route_identifier_name' => 'vehicle_gps_log_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            \Vehicle\Entity\VehicleGpsLog::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'vehicle.rest.vehicle-gps-log',
                'route_identifier_name' => 'vehicle_gps_log_id',
                'hydrator' => 'Vehicle\\Hydrator\\VehicleGpsLog',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Vehicle\\V1\\Rest\\Vehicle\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
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
            'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
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
        'Vehicle\\V1\\Rest\\Vehicle\\Controller' => [
            'input_filter' => 'Vehicle\\V1\\Rest\\Vehicle\\Validator',
        ],
        'Vehicle\\V1\\Rest\\VehicleGpsLog\\Controller' => [
            'input_filter' => 'Vehicle\\V1\\Rest\\VehicleGpsLog\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Vehicle\\V1\\Rest\\Vehicle\\Validator' => [
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
                'name' => 'plate',
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
                'name' => 'note',
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
                'name' => 'gps_id',
            ],
            3 => [
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
            4 => [
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
            ],
        ],
        'Vehicle\\V1\\Rest\\VehicleGpsLog\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'vehicle_id',
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
                'name' => 'gps_id',
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
                'name' => 'latitude',
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
                'name' => 'longitude',
            ],
            4 => [
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
                'name' => 'speed',
            ],
        ],
    ],
];
