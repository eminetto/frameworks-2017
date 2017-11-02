<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;
use Zend\ModuleManager\ModuleManager;

class Module {

    const VERSION = '3.0.3-dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($event) {
            $controller = $event->getTarget();
            $controllerName = get_class($controller);
            $moduleNamespace = substr($controllerName, 0, strpos($controllerName, '\\'));
            $configs = $event->getApplication()->getServiceManager()->get('config');
            $action = $event->getRouteMatch()->getParam('action');
            $action = 'action' . $action;

            if (isset($configs['module_layouts'][$action])) {
                $controller->layout($configs['module_layouts'][$action]);
            } elseif (isset($configs['module_layouts'][$moduleNamespace])) {
                $controller->layout($configs['module_layouts'][$moduleNamespace]);
            }
        }, 100);
    }

    public function init(ModuleManager $moduleManager) {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController", MvcEvent::EVENT_DISPATCH, array($this, 'validaAuth'), 100);
    }

    public function validaAuth(MvcEvent $e) {
        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch();
        $moduleName = $matchedRoute->getParam('module');
        $controllerName = $matchedRoute->getParam('controller');

        if ($moduleName !== 'auth') {
        
            $auth = new AuthenticationService();
            $redirect = $e->getTarget()->redirect();
            
            if (!$auth->hasIdentity()) {
                $e->setResponse($redirect->toRoute('login'));
                return false;
            }
        }

        return true;
    }

}
