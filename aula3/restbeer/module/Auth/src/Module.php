<?php

namespace Auth;

use Auth\Form\Factory\LoginFilterFactory;
use Auth\Form\Factory\LoginFormFactory;
use Auth\Form\LoginFilter;
use Auth\Form\LoginForm;
use Auth\Model\Factory\UserRepositoryFactory;
use Auth\Model\Factory\UsersFactory;
use Auth\Model\Users;
use Auth\Model\UsersRepository;
use Auth\Storage\Authenticate;
use Auth\Storage\Factory\AutheticateFactory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface {

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig() {
        return [
            'factories' => [
                LoginForm::class => LoginFormFactory::class,
                LoginFilter::class => LoginFilterFactory::class,
                Users::class => UsersFactory::class,
                UsersRepository::class => UserRepositoryFactory::class,
                Authenticate::class => AutheticateFactory::class
            ]
        ];
    }

}
