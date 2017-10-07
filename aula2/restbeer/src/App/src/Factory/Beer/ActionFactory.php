<?php

namespace App\Factory\Beer;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;

class ActionFactory
{
    public function __invoke(ContainerInterface $container, $actionName)
    {
        $adapter = $container->get('Sqlite');
        $tableGateway = new TableGateway('beer', $adapter);

        return new $actionName($tableGateway);
    }
}
