<?php
return [
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\SoftDeleteable\SoftDeleteableListener'
                ],
            ],
        ],
        'driver' => [
            'vehicle_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'User\Entity' => 'user_entity',
                    'Vehicle\Entity' => 'vehicle_entity',

                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'filters' => [
                    'soft-deleteable' => 'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
                ]
            ]
        ]
    ]
];
