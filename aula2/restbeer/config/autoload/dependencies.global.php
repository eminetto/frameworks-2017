<?php

use Zend\Expressive\Application;
use Zend\Expressive\Container;
use Zend\Expressive\Delegate;
use Zend\Expressive\Helper;
use Zend\Expressive\Middleware;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            'Zend\Expressive\Delegate\DefaultDelegate' => Delegate\NotFoundDelegate::class,
            'Mysql' => App\Factory\Db\Adapter\Adapter::class,
            'Postgresql' => App\Factory\Db\Adapter\Adapter::class,
            'Oracle' => App\Factory\Db\Adapter\Adapter::class,
            'Sqlite' => App\Factory\Db\Adapter\Adapter::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
            App\Middleware\Format\Json::class => App\Middleware\Format\Json::class,
            App\Middleware\Auth::class => App\Middleware\Auth::class,
            App\Middleware\Validate::class => App\Middleware\Validate::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            Application::class                => Container\ApplicationFactory::class,
            Delegate\NotFoundDelegate::class  => Container\NotFoundDelegateFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelper::class           => Helper\UrlHelperFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,

            Zend\Stratigility\Middleware\ErrorHandler::class => Container\ErrorHandlerFactory::class,
            Middleware\ErrorResponseGenerator::class         => Container\ErrorResponseGeneratorFactory::class,
            Middleware\NotFoundHandler::class                => Container\NotFoundHandlerFactory::class,
            // 'Sqlite' => App\Factory\Db\Adapter\Adapter::class,
            App\Factory\Db\Adapter\Adapter::class => App\Factory\Db\Adapter\Adapter::class,
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\Beer\Index::class => App\Factory\Beer\ActionFactory::class,
            App\Action\Beer\Update::class => App\Factory\Beer\ActionFactory::class,
            App\Action\Beer\Create::class => App\Factory\Beer\ActionFactory::class,
            App\Action\Beer\Delete::class => App\Factory\Beer\ActionFactory::class,
            App\Middleware\Format\Html::class => App\Factory\Middleware\Format\Html::class
        ],
    ],
];
