<?php

namespace App\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Middleware\Validate as Middleware;


class Validate
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        if (!isset($config['validate'])) {
            $config['validate'] = [];
        }
        return new Middleware($config['validate']);
    }
}
