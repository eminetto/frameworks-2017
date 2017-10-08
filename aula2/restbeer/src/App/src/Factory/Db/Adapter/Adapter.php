<?php

namespace App\Factory\Db\Adapter;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter as ZendAdapter;

class Adapter
{
    public function __invoke(ContainerInterface $container, $name)
    {
        $config = $container->get('config');
        switch ($name) {
            case 'Sqlite':
                $dbConfig = $config['db']['sqlite'];
                break;
            case 'Mysql':
                $dbConfig = $config['db']['mysql'];
                break;
            
            default:
                # code...
                break;
        }
        if (empty($dbConfig)) {
            $dbConfig = $config['db']['sqlite'];
        }
        return new ZendAdapter($dbConfig);
    }
}