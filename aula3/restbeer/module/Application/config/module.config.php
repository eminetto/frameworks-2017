<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                        'module' => 'application',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                        'module' => 'application',
                    ],
                ],
            ],
            // 'beer_1' => [
            //     'type'    => Segment::class,
            //     'options' => [
            //         'route'    => '/beer[/][:id]',
            //         'constraints' => [
            //             'id'     => '[0-9]+',
            //         ],
            //         'defaults' => [
            //             'controller' => Controller\BeerController::class,
            //             'action'     => 'get',
            //         ],
            //     ],
            // ],
            'beer' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/beer[/][:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\BeerController::class,
                        'action' => 'index',
                        'module' => 'application',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\BeerController::class => function(\Interop\Container\ContainerInterface $container, $requestedName) {
                $tableGateway = $container->get('Application\Model\BeerTableGateway');
                $controller = new Controller\BeerController($tableGateway);

                return $controller;
            },
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'my_auth_service' => AuthenticationService::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
