<?php

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactory;
use Auth\Controller\Factory\LoginControllerFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/login[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'login',
                        'module' => 'auth',
                    ],
                ],
            ],
            'logout' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/logout[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'logout',
                        'module' => 'auth',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => AuthControllerFactory::class,
            Controller\LoginController::class => LoginControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'my_auth_service' => AuthenticationService::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'Auth/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
