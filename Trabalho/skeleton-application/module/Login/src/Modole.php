<?php
/**
 * Created by PhpStorm.
 * User: apiov
 * Date: 22/10/2017
 * Time: 18:39
 */

namespace Login;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Modole implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include_once __DIR__ . '/../config/module.config.php';
    }
}